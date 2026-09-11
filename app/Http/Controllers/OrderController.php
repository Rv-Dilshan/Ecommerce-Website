<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show the checkout page.
     */
    public function checkout()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('cart_message', 'Your cart is empty.');
        }

        // Validate stock for all items
        foreach ($cartItems as $item) {
            $product = $item->product;
            if ($product->product_quantity !== null && $item->quantity > $product->product_quantity) {
                return redirect()->route('cart.index')->with('cart_error', 'Sorry, "' . $product->product_title . '" has insufficient stock (Only ' . $product->product_quantity . ' left). Please adjust your quantity in the cart.');
            }
        }

        $total = $cartItems->sum(fn ($item) => $item->product->product_price * $item->quantity);

        return view('checkout', compact('cartItems', 'total'));
    }

    /**
     * Process the checkout and place the order.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // Validate stock for all items
        foreach ($cartItems as $item) {
            $product = $item->product;
            if ($product->product_quantity !== null && $item->quantity > $product->product_quantity) {
                return redirect()->route('cart.index')->with('cart_error', 'Sorry, "' . $product->product_title . '" has insufficient stock (Only ' . $product->product_quantity . ' left). Please update your quantity in the cart.');
            }
        }

        $total = $cartItems->sum(fn ($item) => $item->product->product_price * $item->quantity);

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total_price' => $total,
            'payment_status' => 'Cash on Delivery',
            'delivery_status' => 'Pending',
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'price' => $item->product->product_price,
                'quantity' => $item->quantity,
            ]);

            // Optional: Decrement product quantity
            if ($item->product->product_quantity !== null) {
                 $item->product->decrement('product_quantity', $item->quantity);
            }
        }

        // Clear the cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.orders')->with('success_message', 'Your order has been placed successfully!');
    }

    /**
     * Display the authenticated user's orders.
     */
    public function userOrders()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user_orders', compact('orders'));
    }

    /**
     * Cancel an order.
     */
    public function cancelOrder(int $id)
    {
        $order = Order::with('orderItems.product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->delivery_status !== 'Pending') {
            return redirect()->route('user.orders')->with('error_message', 'Sorry, this order cannot be cancelled as it is already ' . $order->delivery_status . '.');
        }

        $order->delivery_status = 'Cancelled';
        $order->save();

        // Restore product stock
        foreach ($order->orderItems as $item) {
            if ($item->product && $item->product->product_quantity !== null) {
                $item->product->increment('product_quantity', $item->quantity);
            }
        }

        return redirect()->route('user.orders')->with('success_message', 'Your order has been cancelled and stock has been restored successfully!');
    }
}
