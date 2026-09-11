@extends('maindesign')
@section('index')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
    
    .orders-wrapper { margin: 40px auto 80px; }
    
    .orders-title {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 30px;
    }

    .order-card {
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .order-header {
        background: #f8fafc;
        padding: 16px 24px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .order-meta div {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .order-meta span {
        font-size: 15px;
        color: #1e293b;
        font-weight: 700;
    }

    .badge-status {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        display: inline-block;
    }
    
    .status-pending { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .status-processing { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .status-shipped { background: #f5f3ff; color: #7c3aed; border: 1px solid #ede9fe; }
    .status-delivered { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .status-cancelled { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

    .order-body {
        padding: 24px;
    }

    .order-item {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .order-item:last-child { border-bottom: none; padding-bottom: 0; }
    .order-item:first-child { padding-top: 0; }

    .item-img {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        background: #f8fafc;
        border: 1px solid #edf2f7;
    }

    .item-details { flex-grow: 1; }
    .item-title { font-size: 15px; font-weight: 600; color: #1e293b; }
    .item-meta { font-size: 14px; color: #64748b; margin-top: 4px; }
    
    .item-price {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        text-align: right;
    }

</style>

<div class="container orders-wrapper">
    <h2 class="orders-title">My Orders</h2>

    @if(session('success_message'))
        <div class="alert alert-success" style="border-radius:10px; font-weight:500; background:#ecfdf5; color:#065f46; border-color:#6ee7b7;">
            <i class="fa fa-check-circle"></i> {{ session('success_message') }}
        </div>
    @endif

    @if(session('error_message'))
        <div class="alert alert-danger" style="border-radius:10px; font-weight:500; background:#fde8e8; color:#9b1c1c; border-color:#fbd5d5;">
            <i class="fa fa-exclamation-circle"></i> {{ session('error_message') }}
        </div>
    @endif

    @if($orders->count() > 0)
        @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div class="d-flex gap-4" style="gap: 2rem;">
                        <div class="order-meta">
                            <div>Order ID</div>
                            <span>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="order-meta">
                            <div>Date Placed</div>
                            <span>{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="order-meta">
                            <div>Total Amount</div>
                            <span>${{ number_format($order->total_price, 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center" style="gap: 15px;">
                        <span class="badge-status status-{{ strtolower($order->delivery_status) }}">
                            Delivery: {{ ucfirst($order->delivery_status) }}
                        </span>
                        @if($order->delivery_status == 'Pending')
                            <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order? This will restore the product stock.');" style="margin: 0; display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" style="background:#ef4444; border:none; padding:6px 14px; border-radius:30px; font-size:13px; font-weight:700; color:#fff; cursor:pointer; transition: background 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                                    Cancel Order
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Order Status Timeline -->
                <div class="order-timeline-container" style="padding: 24px 24px 15px; border-bottom: 1px solid #f1f5f9; background: #fafbfc;">
                    @if($order->delivery_status == 'Cancelled')
                        <div class="d-flex align-items-center" style="gap: 10px; color: #dc2626;">
                            <i class="fa fa-times-circle" style="font-size: 20px;"></i>
                            <span style="font-weight: 700; font-size: 15px;">This order has been cancelled.</span>
                        </div>
                    @else
                        @php
                            $statuses = ['Pending', 'Processing', 'Shipped', 'Delivered'];
                            $currentIndex = array_search($order->delivery_status, $statuses);
                        @endphp
                        <div class="timeline" style="display: flex; justify-content: space-between; position: relative; margin-top: 5px; padding: 0 10px; max-width: 500px; margin-left: auto; margin-right: auto;">
                            <!-- Progress line -->
                            <div class="progress-line" style="position: absolute; top: 14px; left: 40px; right: 40px; height: 4px; background: #e2e8f0; z-index: 1;">
                                <div class="progress-line-fill" style="height: 100%; background: #db6574; transition: width 0.3s; width: {{ $currentIndex * 33.33 }}%;"></div>
                            </div>
                            
                            @foreach($statuses as $index => $status)
                                <div class="timeline-step" style="text-align: center; z-index: 2; position: relative; width: 80px;">
                                    <div class="step-icon" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 13px; font-weight: 700; transition: all 0.3s;
                                        @if($index <= $currentIndex)
                                            background: #db6574; color: #fff; border: 2px solid #db6574; box-shadow: 0 0 10px rgba(219, 101, 116, 0.2);
                                        @else
                                            background: #fff; color: #94a3b8; border: 2px solid #cbd5e1;
                                        @endif
                                    ">
                                        @if($index < $currentIndex || $order->delivery_status == 'Delivered')
                                            <i class="fa fa-check"></i>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <span style="display: block; font-size: 12px; font-weight: 600; 
                                        @if($index <= $currentIndex)
                                            color: #db6574;
                                        @else
                                            color: #64748b;
                                        @endif
                                    ">{{ $status }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="order-body">
                    @foreach($order->orderItems as $item)
                        <div class="order-item">
                            @if($item->product->product_image)
                                <img src="{{ asset('images/' . $item->product->product_image) }}" class="item-img" alt="" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}';">
                            @else
                                <img src="{{ asset('images/placeholder.svg') }}" class="item-img" alt="No Image">
                            @endif
                            
                            <div class="item-details">
                                <div class="item-title">{{ $item->product->product_title }}</div>
                                <div class="item-meta">Qty: {{ $item->quantity }} • ${{ number_format($item->price, 2) }} each</div>
                            </div>
                            
                            <div class="item-price">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div style="background:#fff; border:1px solid #edf2f7; border-radius:16px; padding:60px 20px; text-align:center;">
            <i class="fa fa-box" style="font-size:60px; color:#e2e8f0; margin-bottom:20px; display:block;"></i>
            <h4 style="font-size:20px; font-weight:700; color:#1e293b; margin-bottom:10px;">No Orders Yet</h4>
            <p style="color:#64748b; margin-bottom:24px;">Looks like you haven't placed any orders.</p>
            <a href="{{ route('index') }}" class="btn btn-primary" style="background:#0f172a; border:none; padding:12px 30px; border-radius:8px; font-weight:600;">Start Shopping</a>
        </div>
    @endif
</div>

@endsection
