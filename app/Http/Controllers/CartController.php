<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(fn ($item) => $item->product->product_price * $item->quantity);

        return view('cart', compact('cartItems', 'total'));
    }

    /**
     * Add a product to the cart or increment its quantity.
     */
    public function addToCart(Request $request, int $productId)
    {
        $product = Product::findOrFail($productId);

        // Check if out of stock
        if ($product->product_quantity !== null && $product->product_quantity <= 0) {
            return redirect()->back()->with('cart_error', 'Sorry, "' . $product->product_title . '" is out of stock!');
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            if ($product->product_quantity !== null && ($cartItem->quantity + 1) > $product->product_quantity) {
                return redirect()->back()->with('cart_error', 'Sorry, you cannot add more. Only ' . $product->product_quantity . ' items are in stock, and you already have ' . $cartItem->quantity . ' in your cart.');
            }
            $cartItem->increment('quantity');
        } else {
            if ($product->product_quantity !== null && 1 > $product->product_quantity) {
                return redirect()->back()->with('cart_error', 'Sorry, only ' . $product->product_quantity . ' items are in stock.');
            }
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('cart_message', '"' . $product->product_title . '" cart එකට add කළා!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function updateQuantity(Request $request, int $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $cartItem = Cart::with('product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $product = $cartItem->product;
        if ($product->product_quantity !== null && $request->quantity > $product->product_quantity) {
            return redirect()->route('cart.index')->with('cart_error', 'Sorry, cannot update quantity. Only ' . $product->product_quantity . ' items are in stock.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('cart_message', 'Quantity updated!');
    }

    /**
     * Remove a single item from the cart.
     */
    public function removeItem(int $id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->route('cart.index')->with('cart_message', 'Item removed from cart.');
    }

    /**
     * Clear all items from the cart.
     */
    public function clearCart()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('cart_message', 'Cart cleared.');
    }
}
