@extends('maindesign')
@section('index')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }

    .cart-wrapper { margin: 40px auto 60px; }

    .cart-title {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .cart-title i { color: #db6574; }

    /* Alert */
    .cart-alert {
        background: #ecfdf5;
        border: 1px solid #6ee7b7;
        color: #065f46;
        padding: 14px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Cart Table Card */
    .cart-card {
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        overflow: hidden;
    }
    .cart-table { width: 100%; border-collapse: collapse; }
    .cart-table thead {
        background: #f8fafc;
        border-bottom: 1px solid #edf2f7;
    }
    .cart-table thead th {
        padding: 16px 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #94a3b8;
    }
    .cart-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    .cart-table tbody tr:last-child { border-bottom: none; }
    .cart-table tbody tr:hover { background: #fafbfc; }
    .cart-table td { padding: 18px 20px; vertical-align: middle; }

    .product-info { display: flex; align-items: center; gap: 16px; }
    .product-img {
        width: 72px;
        height: 72px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #edf2f7;
        background: #f8fafc;
    }
    .product-name { font-weight: 600; color: #1e293b; font-size: 15px; }
    .product-cat  { font-size: 12px; color: #94a3b8; margin-top: 3px; }

    .item-price { font-weight: 600; color: #475569; }

    /* Quantity stepper */
    .qty-form { display: flex; align-items: center; gap: 0; }
    .qty-btn {
        width: 32px; height: 32px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        border-radius: 0;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.15s;
        line-height: 1;
    }
    .qty-btn:first-child { border-radius: 8px 0 0 8px; }
    .qty-btn:last-child  { border-radius: 0 8px 8px 0; }
    .qty-btn:hover { background: #e2e8f0; }
    .qty-input {
        width: 44px; height: 32px;
        border: 1px solid #e2e8f0;
        border-left: none; border-right: none;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        background: #fff;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }

    .item-subtotal { font-weight: 700; color: #0f172a; }

    .btn-remove {
        background: none;
        border: none;
        color: #cbd5e1;
        font-size: 18px;
        cursor: pointer;
        padding: 6px;
        border-radius: 6px;
        transition: color 0.15s, background 0.15s;
    }
    .btn-remove:hover { color: #ef4444; background: #fef2f2; }

    /* Summary Card */
    .summary-card {
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        padding: 28px;
        position: sticky;
        top: 20px;
    }
    .summary-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        font-size: 15px;
        color: #475569;
    }
    .summary-row.total {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        padding-top: 16px;
        margin-top: 6px;
        border-top: 2px solid #f1f5f9;
    }
    .summary-row.total span:last-child { color: #db6574; }

    .btn-checkout {
        display: block;
        width: 100%;
        background: #0f172a;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        margin-top: 20px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-checkout:hover {
        background: #1e293b;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(15,23,42,0.15);
    }
    .btn-clear {
        display: block;
        width: 100%;
        background: #fff;
        color: #ef4444;
        border: 1px solid #fecaca;
        font-size: 14px;
        font-weight: 600;
        border-radius: 10px;
        padding: 12px;
        text-align: center;
        margin-top: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-clear:hover { background: #fef2f2; }

    /* Empty cart */
    .empty-cart {
        text-align: center;
        padding: 80px 20px;
    }
    .empty-cart i { font-size: 60px; color: #e2e8f0; margin-bottom: 20px; display: block; }
    .empty-cart h4 { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 10px; }
    .empty-cart p { color: #94a3b8; margin-bottom: 28px; }
    .btn-shop {
        background: #db6574;
        color: #fff;
        padding: 12px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-block;
    }
    .btn-shop:hover { background: #c25261; color: #fff; transform: translateY(-2px); }
</style>

<div class="container cart-wrapper">
    <h2 class="cart-title">
        <i class="fa fa-shopping-bag"></i> Shopping Cart
        @if($cartItems->count() > 0)
            <span style="font-size:16px; font-weight:500; color:#94a3b8; margin-left:4px;">({{ $cartItems->count() }} {{ Str::plural('item', $cartItems->count()) }})</span>
        @endif
    </h2>

    @if($cartItems->count() > 0)
        <div class="row">
            {{-- Cart Items --}}
            <div class="col-lg-8 mb-4">
                <div class="cart-card">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                {{-- Product Info --}}
                                <td>
                                    <div class="product-info">
                                        @if($item->product->product_image)
                                            <img src="{{ asset('images/' . $item->product->product_image) }}" alt="{{ $item->product->product_title }}" class="product-img" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}';">
                                        @else
                                            <img src="{{ asset('images/placeholder.svg') }}" alt="No Image" class="product-img">
                                        @endif
                                        <div>
                                            <div class="product-name">{{ $item->product->product_title }}</div>
                                            <div class="product-cat">{{ $item->product->product_category }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Unit Price --}}
                                <td class="item-price">${{ number_format($item->product->product_price, 2) }}</td>

                                {{-- Quantity Stepper --}}
                                <td>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="qty-form" id="qty-form-{{ $item->id }}">
                                        @csrf
                                        <button type="button" class="qty-btn" onclick="changeQty({{ $item->id }}, -1)">−</button>
                                        <input type="number" name="quantity" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="99" class="qty-input" onchange="document.getElementById('qty-form-{{ $item->id }}').submit()">
                                        <button type="button" class="qty-btn" onclick="changeQty({{ $item->id }}, 1)">+</button>
                                    </form>
                                </td>

                                {{-- Subtotal --}}
                                <td class="item-subtotal">${{ number_format($item->product->product_price * $item->quantity, 2) }}</td>

                                {{-- Remove --}}
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove" title="Remove">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Continue Shopping --}}
                <div class="mt-3">
                    <a href="{{ route('index') }}" style="color:#64748b; font-size:14px; font-weight:500; text-decoration:none;">
                        <i class="fa fa-arrow-left" style="margin-right:6px;"></i> Continue Shopping
                    </a>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-lg-4">
                <div class="summary-card">
                    <div class="summary-title">Order Summary</div>

                    <div class="summary-row">
                        <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span style="color:#22c55e; font-weight:600;">Free</span>
                    </div>

                    <div class="summary-row total">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout') }}" class="btn-checkout">
                        <i class="fa fa-lock" style="margin-right:8px;"></i> Proceed to Checkout
                    </a>

                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Cart clear කරන්නද?')">
                        @csrf
                        <button type="submit" class="btn-clear">
                            <i class="fa fa-trash-o" style="margin-right:6px;"></i> Clear Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>

    @else
        {{-- Empty Cart --}}
        <div class="cart-card">
            <div class="empty-cart">
                <i class="fa fa-shopping-bag"></i>
                <h4>Your cart is empty</h4>
                <p>Products add කරලා shopping start කරන්න!</p>
                <a href="{{ route('index') }}" class="btn-shop">
                    <i class="fa fa-arrow-left" style="margin-right:8px;"></i> Shop Now
                </a>
            </div>
        </div>
    @endif
</div>

<script>
function changeQty(itemId, delta) {
    const input = document.getElementById('qty-' + itemId);
    let newVal = parseInt(input.value) + delta;
    if (newVal < 1) newVal = 1;
    if (newVal > 99) newVal = 99;
    input.value = newVal;
    document.getElementById('qty-form-' + itemId).submit();
}
</script>

@endsection
