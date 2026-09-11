@extends('maindesign') 
@section('index') 

<!-- Google Fonts එකක් එකතු කරමු පෙනුම තවත් professional කරන්න -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
    }
    .product-details-wrapper {
        margin: 40px auto;
    }
    .main-card {
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        padding: 40px;
    }
    .pro-img-container {
        background-color: #f8fafc;
        padding: 30px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #f1f5f9;
        height: 100%;
        min-height: 400px;
    }
    .pro-img-container img {
        max-width: 100%;
        max-height: 420px;
        height: auto;
        border-radius: 8px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .pro-img-container img:hover {
        transform: scale(1.02);
    }
    .pro-title {
        font-size: 34px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.5px;
        line-height: 1.2;
    }
    .category-badge {
        background-color: #f1f5f9;
        color: #64748b;
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .pro-price {
        font-size: 30px;
        color: #db6574; 
        font-weight: 700;
        margin: 15px 0;
    }
    .description-heading {
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .product-description p {
        line-height: 1.8;
        color: #475569;
        font-size: 15px;
    }
    .btn-add-cart {
        background-color: #0f172a;
        color: #ffffff;
        border: none;
        font-size: 16px;
        font-weight: 600;
        border-radius: 10px;
        padding: 16px 40px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .btn-add-cart:hover {
        background-color: #1e293b;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.15);
    }

    /* Modern Customer Review Styles */
    .review-section {
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        padding: 40px;
        margin-top: 30px;
    }
    .review-title {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .single-review {
        border-bottom: 1px solid #f1f5f9;
        padding: 24px 0;
        display: flex;
        gap: 20px;
    }
    .single-review:last-child {
        border-bottom: none;
    }
    .review-avatar {
        width: 48px;
        height: 48px;
        background-color: #e2e8f0;
        color: #475569;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }
    .review-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 4px;
    }
    .review-user {
        font-weight: 600;
        color: #1e293b;
        font-size: 16px;
    }
    .review-date {
        font-size: 13px;
        color: #94a3b8;
    }
    .review-stars {
        color: #ffb547; /* ලස්සන රන්වන් පැහැයක් */
        font-size: 14px;
        margin-bottom: 8px;
    }
    .review-text {
        color: #475569;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 0;
    }
    .add-review-box {
        background: #f8fafc;
        padding: 30px;
        border-radius: 12px;
        margin-top: 40px;
        border: 1px solid #f1f5f9;
    }
    .add-review-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 20px;
    }
    .form-label {
        font-weight: 600;
        color: #344054;
        font-size: 14px;
        margin-bottom: 6px;
    }
    .form-control, .star-rating-select {
        border-radius: 8px;
        border: 1px solid #d0d5dd;
        padding: 10px 14px;
        font-size: 15px;
        color: #1d2939;
        background-color: #ffffff;
        box-shadow: 0px 1px 2px rgba(16, 24, 40, 0.05);
    }
    .form-control:focus, .star-rating-select:focus {
        border-color: #db6574;
        box-shadow: 0px 0px 0px 4px rgba(219, 101, 116, 0.1);
        outline: none;
    }
    .star-rating-select {
        width: 100%;
        height: 45px;
        cursor: pointer;
    }
    .btn-submit-review {
        background-color: #db6574;
        border: none;
        color: #ffffff;
        font-weight: 600;
        font-size: 15px;
        padding: 12px 30px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-submit-review:hover {
        background-color: #c25261;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(219, 101, 116, 0.2);
    }
</style>

<div class="container product-details-wrapper">
    <!-- Main Product Card -->
    <div class="main-card">
        <div class="row">
            <!-- Left Side: Image -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="pro-img-container">
                    @if($product->product_image)
                        <img src="{{ asset('/images/' . $product->product_image) }}" alt="{{ $product->product_title }}" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}';">
                    @else
                        <img src="{{ asset('images/placeholder.svg') }}" alt="No Image">
                    @endif
                </div>
            </div>

            <!-- Right Side: Details -->
            <div class="col-md-6 lg-ps-5" style="padding-left: 25px;">
                <div class="mb-3">
                    <span class="category-badge">
                        {{ $product->product_category ?? 'General' }}
                    </span>
                </div>
                
                <h1 class="pro-title">{{ $product->product_title }}</h1>
                <div class="pro-price">${{ number_format($product->product_price, 2) }}</div>
                
                <hr style="border-top: 1px solid #f1f5f9; margin: 24px 0;">
                
                <div class="product-description">
                    <h5 class="description-heading">Product Description</h5>
                    <p>
                        {{ $product->product_description }}
                    </p>
                </div>
                
                <hr style="border-top: 1px solid #f1f5f9; margin: 24px 0;">

                <div class="mt-4">
                    @if($product->product_quantity !== null && $product->product_quantity <= 0)
                        <button disabled class="btn btn-add-cart" style="background-color:#f1f5f9; color:#94a3b8; border:1px solid #e2e8f0; cursor:not-allowed; box-shadow:none; transform:none;">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Out of Stock
                        </button>
                    @else
                        @auth
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-add-cart">
                                <i class="fa fa-shopping-bag" aria-hidden="true"></i> Add to Cart
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-add-cart">
                            <i class="fa fa-shopping-bag" aria-hidden="true"></i> Login to Add to Cart
                        </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Card -->
    <div class="review-section">
        <h3 class="review-title">
            <i class="fa fa-comments-o" aria-hidden="true" style="color: #db6574;"></i> 
            Customer Reviews
            @if($product->reviews->count() > 0)
                @php $avgRating = round($product->reviews->avg('rating'), 1); @endphp
                <span style="font-size:16px; font-weight:500; color:#64748b; margin-left:8px;">
                    ({{ $product->reviews->count() }} review{{ $product->reviews->count() > 1 ? 's' : '' }} · ⭐ {{ $avgRating }}/5)
                </span>
            @endif
        </h3>

        {{-- Flash messages --}}
        @if(session('review_success'))
            <div class="alert alert-success" style="border-radius:10px; background:#ecfdf5; color:#065f46; border-color:#6ee7b7; margin-bottom:20px;">
                <i class="fa fa-check-circle"></i> {{ session('review_success') }}
            </div>
        @endif
        @if(session('review_error'))
            <div class="alert alert-danger" style="border-radius:10px; background:#fde8e8; color:#9b1c1c; border-color:#fbd5d5; margin-bottom:20px;">
                <i class="fa fa-exclamation-circle"></i> {{ session('review_error') }}
            </div>
        @endif

        <!-- Reviews List -->
        <div class="review-list">
            @forelse($product->reviews->sortByDesc('created_at') as $review)
                <div class="single-review">
                    <div class="review-avatar">{{ strtoupper(substr($review->user->name, 0, 2)) }}</div>
                    <div style="flex: 1;">
                        <div class="review-meta">
                            <span class="review-user">{{ $review->user->name }}</span>
                            <span class="review-date">• {{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="review-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star{{ $i > $review->rating ? '-o' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="review-text">{{ $review->comment }}</p>
                    </div>
                </div>
            @empty
                <p style="color:#94a3b8; font-style:italic;">No reviews yet. Be the first to share your experience!</p>
            @endforelse
        </div>

        <!-- Write a Review Form Box -->
        <div class="add-review-box">
            @auth
                @if($userReview)
                    <h4 class="add-review-title">Your Review</h4>
                    <p style="color:#64748b;">You already reviewed this product.</p>
                    <div class="review-stars" style="font-size:18px; margin-bottom:10px;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star{{ $i > $userReview->rating ? '-o' : '' }}"></i>
                        @endfor
                    </div>
                    <p style="color:#475569;">{{ $userReview->comment }}</p>
                @else
                    <h4 class="add-review-title">Write a Review</h4>
                    @if($errors->any())
                        <div style="background:#fde8e8; color:#9b1c1c; border:1px solid #fbd5d5; border-radius:8px; padding:12px 16px; margin-bottom:15px; font-size:13px;">
                            <ul style="margin:0; padding-left:18px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('review.store', $product->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Rating (Stars)</label>
                            <select name="rating" class="star-rating-select" required>
                                <option value="">-- Select a rating --</option>
                                <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5/5 — Excellent)</option>
                                <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4/5 — Good)</option>
                                <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (3/5 — Average)</option>
                                <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ (2/5 — Poor)</option>
                                <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ (1/5 — Terrible)</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Your Review</label>
                            <textarea name="comment" class="form-control" rows="4" placeholder="Share your experience with this product..." required>{{ old('comment') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-submit-review">
                            Submit Review
                        </button>
                    </form>
                @endif
            @else
                <h4 class="add-review-title">Write a Review</h4>
                <p style="color:#64748b;">Please <a href="{{ route('login') }}" style="color:#db6574; font-weight:700;">login</a> to submit a review.</p>
            @endauth
        </div>
    </div>
</div>

@endsection