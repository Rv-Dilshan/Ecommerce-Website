<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index(): \Illuminate\View\View
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('wishlist', compact('wishlistItems'));
    }

    /**
     * Toggle a product in/out of the wishlist.
     */
    public function toggle(int $productId): \Illuminate\Http\RedirectResponse
    {
        $product = Product::findOrFail($productId);

        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return redirect()->back()->with('wishlist_message', '"' . $product->product_title . '" wishlist එකෙන් ඉවත් කළා.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);

        return redirect()->back()->with('wishlist_message', '"' . $product->product_title . '" wishlist එකට add කළා! ❤️');
    }

    /**
     * Remove a specific wishlist item.
     */
    public function remove(int $id): \Illuminate\Http\RedirectResponse
    {
        Wishlist::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->route('wishlist.index')->with('wishlist_message', 'Item removed from wishlist.');
    }
}
