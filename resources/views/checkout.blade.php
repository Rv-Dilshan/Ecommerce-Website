@extends('maindesign')
@section('index')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }

    .checkout-wrapper { margin: 40px auto 60px; }

    .checkout-title {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 28px;
    }

    .checkout-card {
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        padding: 30px;
        margin-bottom: 24px;
    }

    .checkout-card h4 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-group label {
        font-weight: 600;
        color: #475569;
        font-size: 14px;
        margin-bottom: 8px;
    }
    
    .form-control {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 12px 16px;
        font-size: 15px;
    }
    
    .form-control:focus {
        border-color: #db6574;
        box-shadow: 0 0 0 3px rgba(219, 101, 116, 0.1);
    }

    /* Summary styling */
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .summary-item:last-child {
        border-bottom: none;
    }
    
    .item-name { font-weight: 600; color: #1e293b; font-size: 14px; }
    .item-qty { color: #94a3b8; font-size: 13px; }
    .item-price { font-weight: 600; color: #475569; font-size: 14px; }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f1f5f9;
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
    }
    .total-row span:last-child { color: #db6574; }

    .btn-place-order {
        width: 100%;
        background: #db6574;
        color: #fff;
        border: none;
        padding: 16px;
        font-size: 16px;
        font-weight: 700;
        border-radius: 10px;
        margin-top: 24px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-place-order:hover {
        background: #c25261;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(219, 101, 116, 0.2);
    }

</style>

<div class="container checkout-wrapper">
    <h2 class="checkout-title">Checkout</h2>

    @if($errors->any())
        <div class="alert alert-danger" style="border-radius:10px;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- Left: Shipping Details -->
        <div class="col-lg-7">
            <div class="checkout-card">
                <h4>Shipping Information</h4>
                <form action="{{ route('place.order') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-4">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required placeholder="Enter your full name">
                    </div>
                    
                    <div class="form-group mb-4">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}" required placeholder="E.g. 077 123 4567">
                    </div>
                    
                    <div class="form-group mb-4">
                        <label>Delivery Address</label>
                        <textarea name="address" class="form-control" rows="4" required placeholder="Enter full delivery address">{{ Auth::user()->address }}</textarea>
                    </div>

            </div>
        </div>

        <!-- Right: Order Summary -->
        <div class="col-lg-5">
            <div class="checkout-card">
                <h4>Order Summary</h4>
                
                <div class="summary-items-list mb-4">
                    @foreach($cartItems as $item)
                        <div class="summary-item">
                            <div>
                                <div class="item-name">{{ $item->product->product_title }}</div>
                                <div class="item-qty">Qty: {{ $item->quantity }}</div>
                            </div>
                            <div class="item-price">${{ number_format($item->product->product_price * $item->quantity, 2) }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="summary-item">
                    <span style="color:#64748b; font-weight:600;">Subtotal</span>
                    <span style="color:#1e293b; font-weight:600;">${{ number_format($total, 2) }}</span>
                </div>
                <div class="summary-item">
                    <span style="color:#64748b; font-weight:600;">Shipping</span>
                    <span style="color:#22c55e; font-weight:600;">Free</span>
                </div>
                
                <div class="total-row">
                    <span>Total Amount</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>

                <div class="mt-4 pt-3" style="border-top:1px solid #f1f5f9;">
                    <label style="font-weight:600; color:#475569; font-size:14px;">Payment Method</label>
                    <div style="background:#f8fafc; padding:14px; border-radius:8px; border:1px solid #e2e8f0; margin-top:8px;">
                        <input type="radio" checked id="cod"> 
                        <label for="cod" style="margin-left:8px; font-weight:600; color:#1e293b; margin-bottom:0;">Cash on Delivery (COD)</label>
                    </div>
                </div>

                <button type="submit" class="btn-place-order">
                    Place Order Now
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
