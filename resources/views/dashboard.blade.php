@extends('maindesign')
@section('index')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }

    .dashboard-wrapper { margin: 40px auto 80px; }

    .welcome-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 16px;
        padding: 40px;
        color: #fff;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
        position: relative;
        overflow: hidden;
    }
    
    .welcome-card::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(219,101,116,0.2) 0%, transparent 70%);
        border-radius: 50%;
    }

    .welcome-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .welcome-subtitle {
        color: #cbd5e1;
        font-size: 15px;
        max-width: 600px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
        text-decoration: none;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        text-decoration: none;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .stat-icon.orders { background: #eff6ff; color: #3b82f6; }
    .stat-icon.cart { background: #fef2f2; color: #ef4444; }
    .stat-icon.profile { background: #f5f3ff; color: #8b5cf6; }

    .stat-info h4 {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
    }
    
    .stat-info p {
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
        margin: 0;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-title i { color: #db6574; }

    /* Quick Actions */
    .quick-action-btn {
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #1e293b;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .quick-action-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #db6574;
    }
    .quick-action-btn i { font-size: 18px; color: #64748b; }
    .quick-action-btn:hover i { color: #db6574; }

</style>

<div class="container dashboard-wrapper">
    
    <!-- Welcome Section -->
    <div class="welcome-card">
        <h2 class="welcome-title">Welcome back, {{ Auth::user()->name }}! 👋</h2>
        <p class="welcome-subtitle">Manage your orders, update your profile, and explore the latest products right from your dashboard.</p>
    </div>

    @php
        $orderCount = \App\Models\Order::where('user_id', Auth::id())->count();
        $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
    @endphp

    <!-- Stats & Quick Links -->
    <div class="row mb-5">
        <div class="col-md-4 mb-4 mb-md-0">
            <a href="{{ route('user.orders') }}" class="stat-card">
                <div class="stat-icon orders">
                    <i class="fa fa-box"></i>
                </div>
                <div class="stat-info">
                    <h4>{{ $orderCount }}</h4>
                    <p>Total Orders</p>
                </div>
            </a>
        </div>
        
        <div class="col-md-4 mb-4 mb-md-0">
            <a href="{{ route('cart.index') }}" class="stat-card">
                <div class="stat-icon cart">
                    <i class="fa fa-shopping-bag"></i>
                </div>
                <div class="stat-info">
                    <h4>{{ $cartCount }}</h4>
                    <p>Items in Cart</p>
                </div>
            </a>
        </div>
        
        <div class="col-md-4">
            <a href="{{ route('profile.edit') }}" class="stat-card">
                <div class="stat-icon profile">
                    <i class="fa fa-user"></i>
                </div>
                <div class="stat-info">
                    <h4>Profile</h4>
                    <p>Account Settings</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Quick Actions & Recommendations -->
    <div class="row">
        
        <!-- Left: Quick Actions -->
        <div class="col-lg-4 mb-4">
            <h4 class="section-title"><i class="fa fa-bolt"></i> Quick Actions</h4>
            
            <div class="d-flex flex-column" style="gap: 12px;">
                <a href="{{ route('index') }}" class="quick-action-btn">
                    <i class="fa fa-shopping-cart"></i> Continue Shopping
                </a>
                
                <a href="{{ route('user.orders') }}" class="quick-action-btn">
                    <i class="fa fa-list"></i> Track My Orders
                </a>
                
                <a href="{{ route('profile.edit') }}" class="quick-action-btn">
                    <i class="fa fa-cog"></i> Account Settings
                </a>

                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="quick-action-btn" style="width: 100%; text-align:left; cursor:pointer;">
                        <i class="fa fa-sign-out" style="color: #ef4444;"></i> <span style="color: #ef4444;">Log Out</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Right: Recommended Products (taking some from $products) -->
        <div class="col-lg-8">
            <h4 class="section-title"><i class="fa fa-star"></i> Featured Products</h4>
            
            <div class="row">
                @foreach($products->take(2) as $product)
                <div class="col-md-6 mb-4">
                    <div style="background:#fff; border:1px solid #edf2f7; border-radius:12px; overflow:hidden; transition:all 0.2s;">
                        <a href="{{ route('user.productdetails', $product->id) }}" style="text-decoration:none; color:inherit;">
                            <div style="height:200px; background:#f8fafc; display:flex; align-items:center; justify-content:center;">
                                @if($product->product_image)
                                    <img src="{{ asset('images/' . $product->product_image) }}" style="width:100%; height:100%; object-fit:cover;" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}';">
                                @else
                                    <img src="{{ asset('images/placeholder.svg') }}" style="width:100%; height:100%; object-fit:cover;">
                                @endif
                            </div>
                            <div style="padding:16px;">
                                <h5 style="font-size:16px; font-weight:600; color:#1e293b; margin-bottom:8px;">{{ $product->product_title }}</h5>
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <span style="font-weight:700; color:#db6574;">${{ number_format($product->product_price, 2) }}</span>
                                    <span style="background:#f1f5f9; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; color:#64748b;">View Details</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

@endsection
