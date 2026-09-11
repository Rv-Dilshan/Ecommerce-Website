@extends('maindesign')
@section('index')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }

    .wishlist-wrapper { margin: 40px auto 80px; }

    .wishlist-title {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .wishlist-title i { color: #db6574; }

    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 24px;
    }

    .wishlist-card {
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }
    .wishlist-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.08);
    }

    .wishlist-card-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #f8fafc;
        display: block;
    }

    .wishlist-card-body { padding: 18px; }
    .wishlist-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }
    .wishlist-card-category {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .wishlist-card-price {
        font-size: 20px;
        font-weight: 700;
        color: #db6574;
        margin-bottom: 16px;
    }

    .wishlist-card-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .btn-add-cart-wl {
        flex: 1;
        background: #0f172a;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        transition: background 0.2s;
    }
    .btn-add-cart-wl:hover { background: #db6574; }

    .btn-remove-wl {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fecaca;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 13px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-remove-wl:hover { background: #fee2e2; }

    .empty-state {
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        padding: 80px 20px;
        text-align: center;
    }
</style>

<div class="container wishlist-wrapper">
    <h2 class="wishlist-title">
        <i class="fa fa-heart"></i> My Wishlist
        @if($wishlistItems->count() > 0)
            <span style="font-size:16px; font-weight:500; color:#94a3b8;">({{ $wishlistItems->count() }} item{{ $wishlistItems->count() > 1 ? 's' : '' }})</span>
        @endif
    </h2>

    @if(session('wishlist_message'))
        <div class="alert alert-success" style="border-radius:12px; background:#ecfdf5; color:#065f46; border-color:#6ee7b7; margin-bottom:20px; font-weight:500;">
            <i class="fa fa-check-circle"></i> {{ session('wishlist_message') }}
        </div>
    @endif

    @if($wishlistItems->count() > 0)
        <div class="wishlist-grid">
            @foreach($wishlistItems as $item)
                @if($item->product)
                <div class="wishlist-card">
                    <a href="{{ route('user.productdetails', $item->product->id) }}">
                        @if($item->product->product_image)
                            <img src="{{ asset('images/' . $item->product->product_image) }}" class="wishlist-card-img" alt="{{ $item->product->product_title }}" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}';">
                        @else
                            <img src="{{ asset('images/placeholder.svg') }}" class="wishlist-card-img" alt="No Image">
                        @endif
                    </a>
                    <div class="wishlist-card-body">
                        <div class="wishlist-card-category">{{ $item->product->product_category ?? 'General' }}</div>
                        <div class="wishlist-card-title">{{ $item->product->product_title }}</div>
                        <div class="wishlist-card-price">${{ number_format($item->product->product_price, 2) }}</div>

                        <div class="wishlist-card-actions">
                            @if($item->product->product_quantity > 0)
                                <form action="{{ route('cart.add', $item->product->id) }}" method="POST" style="flex:1;">
                                    @csrf
                                    <button type="submit" class="btn-add-cart-wl" style="width:100%;">
                                        <i class="fa fa-shopping-bag"></i> Add to Cart
                                    </button>
                                </form>
                            @else
                                <button disabled class="btn-add-cart-wl" style="background:#f1f5f9; color:#94a3b8; cursor:not-allowed; flex:1;">
                                    Out of Stock
                                </button>
                            @endif

                            <form action="{{ route('wishlist.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove-wl" title="Remove from wishlist">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fa fa-heart-o" style="font-size:60px; color:#fecaca; margin-bottom:20px; display:block;"></i>
            <h4 style="font-size:20px; font-weight:700; color:#1e293b; margin-bottom:10px;">Your wishlist is empty</h4>
            <p style="color:#64748b; margin-bottom:24px;">Browse products and click the ❤️ icon to save them here.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary" style="background:#db6574; border:none; padding:12px 30px; border-radius:8px; font-weight:600;">
                Start Shopping
            </a>
        </div>
    @endif
</div>

@endsection
