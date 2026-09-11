@extends('admin.maindesign')

@section('view_order')

@if(session('order_message'))
<div class="alert alert-success" role="alert" style="padding: 15px; background-color: #def7ec; color: #03543f; border: 1px solid #bfecdb; border-radius: 6px; margin-bottom: 20px; font-family: sans-serif;">
        {{ session('order_message') }}
</div>
@endif

<style>
    .custom-table-container {
        margin: 20px 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        background-color: #ffffff;
    }

    .pro-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        text-align: left;
    }

    .pro-table thead tr {
        background-color: #1e293b; 
        color: #ffffff;
        font-weight: 600;
    }

    .pro-table th, .pro-table td {
        padding: 14px 20px;
        vertical-align: middle; 
    }

    .pro-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s ease;
    }

    .pro-table tbody tr:nth-of-type(even) {
        background-color: #f8fafc;
    }

    .pro-table tbody tr:hover {
        background-color: #f1f5f9;
    }

    .pro-table tbody tr.items-row {
        background-color: #f1f5f9;
        border-bottom: 2px solid #1e293b;
    }

    .pro-table tbody tr:last-of-type {
        border-bottom: 2px solid #1e293b;
    }

    .status-select {
        padding: 6px;
        border-radius: 4px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        outline: none;
    }
    
    .btn-update {
        background: #db6574;
        color: #fff;
        border: none;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
    }
    .btn-update:hover { background: #c25261; }

</style>

<style>
    .filter-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 15px 20px;
        margin: 20px 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .filter-card form {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }
    .filter-card select, .filter-card input {
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        outline: none;
        font-size: 14px;
    }
    .filter-card button {
        background: #1e293b;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
    }
    .filter-card button:hover { background: #334155; }
    .filter-card .reset-btn {
        background: #f1f5f9;
        color: #475569;
    }
    .filter-card .reset-btn:hover { background: #e2e8f0; }
</style>

<div class="filter-card">
    <h4 style="margin: 0; font-size: 18px; font-weight: 600; color: #1e293b;">Orders</h4>
    <form action="{{ route('admin.vieworder') }}" method="GET">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, ID or phone...">
        <select name="status">
            <option value="">All Statuses</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
            <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
        </select>
        <button type="submit">Filter</button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.vieworder') }}" class="btn btn-sm reset-btn" style="padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600;">Clear</a>
        @endif
    </form>
</div>

<div class="custom-table-container">
    <table class="pro-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Total</th>
                <th>Payment Status</th>
                <th>Delivery Status</th>
                <th>Date</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td style="font-weight:600;">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        {{ $order->name }}<br>
                        <span style="color:#64748b; font-size:12px;">{{ $order->user->email ?? 'N/A' }}</span>
                        <br>
                        <span style="color:#64748b; font-size:12px;">{{ $order->address }}</span>
                    </td>
                    <td>{{ $order->phone }}</td>
                    <td style="font-weight:600;">${{ number_format($order->total_price, 2) }}</td>
                    
                    <!-- Payment Status -->
                    <td>
                        <form action="{{ route('admin.updateorderstatus', $order->id) }}" method="POST" style="display: flex; gap: 5px;">
                            @csrf
                            <select name="payment_status" class="status-select">
                                <option value="Cash on Delivery" {{ $order->payment_status == 'Cash on Delivery' ? 'selected' : '' }}>COD</option>
                                <option value="Paid" {{ $order->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                            <button type="submit" class="btn-update">✓</button>
                        </form>
                    </td>

                    <!-- Delivery Status -->
                    <td>
                        <form action="{{ route('admin.updateorderstatus', $order->id) }}" method="POST" style="display: flex; gap: 5px;">
                            @csrf
                            <select name="delivery_status" class="status-select">
                                <option value="Pending" {{ $order->delivery_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Processing" {{ $order->delivery_status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Shipped" {{ $order->delivery_status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="Delivered" {{ $order->delivery_status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="Cancelled" {{ $order->delivery_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="btn-update">✓</button>
                        </form>
                    </td>

                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    
                    <td style="text-align: center; white-space: nowrap;">
                        <button style="background:#1e293b; color:#fff; border:none; padding:6px 12px; border-radius:4px; font-size:12px; cursor:pointer; margin-bottom:5px; width:100px;" data-toggle="collapse" data-target="#orderItems{{ $order->id }}">
                            View Items
                        </button>
                        <br>
                        <a href="{{ route('admin.printinvoice', $order->id) }}" style="background:#db6574; color:#fff; text-decoration:none; display:inline-block; padding:6px 12px; border-radius:4px; font-size:12px; cursor:pointer; width:100px; text-align:center;">
                            <i class="fa fa-print"></i> Invoice
                        </a>
                    </td>
                </tr>
                
                <!-- Order Items Row -->
                <tr id="orderItems{{ $order->id }}" class="collapse items-row">
                    <td colspan="8" style="padding: 0;">
                        <div style="padding: 15px 30px; border-left: 4px solid #db6574;">
                            <h6 style="margin-bottom: 10px; font-weight: 600;">Ordered Items:</h6>
                            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                                <thead>
                                    <tr style="border-bottom: 1px solid #cbd5e1; color:#475569;">
                                        <th style="padding: 8px 0; text-align:left;">Product</th>
                                        <th style="padding: 8px 0; text-align:center;">Quantity</th>
                                        <th style="padding: 8px 0; text-align:right;">Price</th>
                                        <th style="padding: 8px 0; text-align:right;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr style="border-bottom: 1px solid #e2e8f0;">
                                        <td style="padding: 8px 0;">
                                            @if($item->product->product_image)
                                                <img src="{{ asset('images/' . $item->product->product_image) }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 10px; vertical-align: middle;" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}';">
                                            @else
                                                <img src="{{ asset('images/placeholder.svg') }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 10px; vertical-align: middle;">
                                            @endif
                                            {{ $item->product->product_title ?? 'Product Removed' }}
                                        </td>
                                        <td style="padding: 8px 0; text-align:center;">{{ $item->quantity }}</td>
                                        <td style="padding: 8px 0; text-align:right;">${{ number_format($item->price, 2) }}</td>
                                        <td style="padding: 8px 0; text-align:right; font-weight:600;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px;">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-container" style="margin: 20px;">
    {{ $orders->links('pagination::bootstrap-4') }}
</div>

@endsection