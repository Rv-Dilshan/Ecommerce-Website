<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review for a product.
     */
    public function store(Request $request, int $productId): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Prevent duplicate reviews
        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->with('review_error', 'You have already submitted a review for this product.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('review_success', 'Thank you for your review!');
    }
}
