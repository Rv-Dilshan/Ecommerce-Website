<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class AdminController extends Controller
{
    public function addCategory()
    {
        return view('admin.addcategory');
    }

    public function postAddCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255|unique:categories,category'
        ]);

        $category = new Category();
        $category->category = $request->category;
        
        $category->save();
        return redirect()->back()->with('category_message', 'Category added successfully!');
    }

    public function viewCategory()
    {
        $categories = Category::all();
        return view('admin.viewcategory', compact('categories'));
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        
        $productCount = Product::where('product_category', $category->category)->count();
        if ($productCount > 0) {
            return redirect()->back()->with('deletecategory_error', 'Cannot delete! There are ' . $productCount . ' products assigned to this category.');
        }

        $category->delete();
        return redirect()->back()->with('deletecategory_message', 'Deleted successfully!');
    }

    public function updateCategory($id)
    {
        $category = Category::find($id);
        return view('admin.updatecategory', compact('category'));
    }

    public function postUpdateCategory(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255|unique:categories,category,' . $id
        ]);

        $category = Category::find($id);
        $category->category = $request->category;
        $category->save();
        return redirect()->route('admin.viewcategory')->with('category_updated_message', 'Category updated successfully!');
    }

    public function addProduct()
    {
        $categories = Category::all();
        return view('admin.addproduct', compact('categories'));
    }

    public function postAddProduct(Request $request)
    {
        $request->validate([
            'product_title' => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_quantity' => 'required|integer|min:0',
            'product_price' => 'required|numeric|min:0',
            'product_category' => 'required|string',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = new Product();
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_quantity = $request->product_quantity;
        $product->product_price = $request->product_price;
        $product->product_category = $request->product_category;

        if ($request->hasFile('product_image')) { 
            $image = $request->file('product_image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imagename);
            $product->product_image = $imagename;
        }
        $product->save();
        return redirect()->back()->with('product_message', 'Product added successfully!');
    }

    public function viewProduct()
    {
        $products = Product::paginate(4);
        return view('admin.viewproduct', compact('products'));
    }

    public function viewOrder(Request $request)
    {
        $query = \App\Models\Order::with('user', 'orderItems.product')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('delivery_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10)->appends($request->query());
        return view('admin.vieworder', compact('orders'));
    }

    public function printInvoice($id)
    {
        $order = \App\Models\Order::with('user', 'orderItems.product')->findOrFail($id);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.invoice', compact('order'));
        return $pdf->download('invoice_ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);

        // Define allowed status transitions
        $statusFlow = [
            'Pending' => ['Processing', 'Cancelled'],
            'Processing' => ['Shipped', 'Cancelled'],
            'Shipped' => ['Delivered'],
            'Delivered' => [],
            'Cancelled' => [],
        ];

        // Update payment status (no restrictions)
        if ($request->filled('payment_status')) {
            $order->payment_status = $request->payment_status;
        }

        // Update delivery status only if transition is allowed
        if ($request->filled('delivery_status')) {
            $current = $order->delivery_status;
            $desired = $request->delivery_status;
            $allowed = $statusFlow[$current] ?? [];
            if (in_array($desired, $allowed) || $desired === $current) {
                $order->delivery_status = $desired;
            } else {
                return redirect()->back()->with('order_message', 'Invalid status transition from ' . $current . ' to ' . $desired . '.');
            }
        }

        $order->save();
        return redirect()->back()->with('order_message', 'Order status updated successfully.');
    }

    public function viewMessages()
    {
        $messages = \App\Models\Contact::orderBy('created_at', 'desc')->get();
        return view('admin.viewmessages', compact('messages'));
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $image_path = public_path('images/' . $product->product_image);
        
        if ($product->product_image && file_exists($image_path) && is_file($image_path)) {
            unlink($image_path);
        }
        $product->delete();
        return redirect()->back()->with('deleteproduct_message', 'Product Deleted Successfully!');
    }
      
    public function updateProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.updateproduct', compact('product', 'categories'));
    }
    
    public function postUpdateProduct(Request $request, $id)
    {
        $request->validate([
            'product_title' => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_quantity' => 'required|integer|min:0',
            'product_price' => 'required|numeric|min:0',
            'product_category' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::findOrFail($id);
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_quantity = $request->product_quantity;
        $product->product_price = $request->product_price;
        $product->product_category = $request->product_category;

        if ($request->hasFile('product_image')) { 
            if ($product->product_image) {
                $old_image_path = public_path('images/' . $product->product_image);
                if (file_exists($old_image_path) && is_file($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            $image = $request->file('product_image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imagename);
            $product->product_image = $imagename;
        }

        $product->save();
        return redirect()->route('admin.viewproduct')->with('update_product_message', 'Product updated successfully!');
    }
      
    public function productSearch(Request $request)
    {
        $search = $request->search;

        $products = Product::where(function($query) use ($search) {
                        $query->where('product_title', 'LIKE', '%' . $search . '%')
                              ->orWhere('product_category', 'LIKE', '%' . $search . '%')
                              ->orWhere('product_description', 'LIKE', '%' . $search . '%'); 
                    })
                    ->paginate(4); 

        return view('admin.viewproduct', compact('products'));
    }

    public function productDetails($id)
    {
        $product = Product::findOrFail($id);
        return view('product_details', compact('product'));
    }
}