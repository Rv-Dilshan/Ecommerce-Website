<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::all();

        if (Auth::check() && Auth::user()?->user_type == "user") {    
            return view('dashboard', compact('products'));
        }

        if (Auth::check() && Auth::user()?->user_type == "admin") {
            $totalUsers = \App\Models\User::where('user_type', 'user')->count();
            $totalProducts = \App\Models\Product::count();
            $totalOrders = \App\Models\Order::count();
            $totalRevenue = \App\Models\Order::where('payment_status', 'Paid')->sum('total_price');

            return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalOrders', 'totalRevenue'));
        }
        
        return redirect()->route('index');
    }

    public function home(Request $request)
    {
        $query = Product::query();

        // Search by keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_title', 'like', "%{$search}%")
                  ->orWhere('product_description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('product_category', $request->category);
        }

        $products = $query->paginate(12)->appends($request->query());
        $categories = \App\Models\Category::all();

        return view('index', compact('products', 'categories'));
    }

    public function productDetails($id)
    {
        $product = Product::with(['reviews.user'])->findOrFail($id);
        $userReview = auth()->check()
            ? $product->reviews->firstWhere('user_id', auth()->id())
            : null;

        return view('product_details', compact('product', 'userReview'));
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        \App\Models\Contact::create($request->all());

        return redirect()->back()->with('contact_success', 'Thank you for contacting us! We will get back to you soon.');
    }
}