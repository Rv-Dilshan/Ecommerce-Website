@extends('admin.maindesign')

@section('view_product')

{{-- Alert Messages --}}
@if(session('category_updated_message'))
<div class="alert alert-success" role="alert" style="padding: 15px; background-color: #def7ec; color: #03543f; border: 1px solid #bfecdb; border-radius: 6px; margin-bottom: 20px; font-family: sans-serif;">
        {{ session('category_updated_message') }}
</div>
@endif

@if(session('deleteproduct_message'))
<div class="alert alert-success" role="alert" style="padding: 15px; background-color: #def7ec; color: #03543f; border: 1px solid #bfecdb; border-radius: 6px; margin-bottom: 20px; font-family: sans-serif;">
        {{ session('deleteproduct_message') }}
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

    .pro-table tbody tr:last-of-type {
        border-bottom: 2px solid #1e293b;
    }

    .pagination-container {
        margin: 20px;
    }
    
    .title-link {
        color: #1e293b;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .title-link:hover {
        color: #db6574; 
        text-decoration: underline;
    }
</style>

<div class="custom-table-container">
    <table class="pro-table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Title</th>
                <th>Product Description</th>
                <th>Product Quantity</th>
                <th>Product Price</th>
                <th>Product Images</th>
                <th>Product Category</th>
                <th colspan="2" style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    <a href="{{ route('admin.productdetails', $product->id) }}" class="title-link">
                        {{ $product->product_title }}
                    </a>
                </td>
                <td>{{ Str::limit($product->product_description, 150) }}</td>
                <td>
                    @if($product->product_quantity == 0)
                        <span style="background-color: #fef2f2; color: #dc2626; padding: 4px 8px; border-radius: 4px; font-weight: 600; border: 1px solid #fecaca; display: inline-block;">
                            <i class="fa fa-exclamation-circle"></i> Out of Stock
                        </span>
                    @elseif($product->product_quantity <= 5)
                        <span style="background-color: #fffbeb; color: #d97706; padding: 4px 8px; border-radius: 4px; font-weight: 600; border: 1px solid #fde68a; display: inline-block;">
                            <i class="fa fa-exclamation-triangle"></i> Low Stock ({{ $product->product_quantity }})
                        </span>
                    @else
                        <span style="background-color: #f0fdf4; color: #166534; padding: 4px 8px; border-radius: 4px; font-weight: 600; border: 1px solid #bbf7d0; display: inline-block;">
                            {{ $product->product_quantity }} In Stock
                        </span>
                    @endif
                </td>
                <td>${{ number_format($product->product_price, 2) }}</td>
                <td>
                    @if($product->product_image)
                       <img src="{{ asset('/images/' . $product->product_image) }}" alt="Product Image" style="width: 100px; height: auto; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}';">
                    @else
                       <img src="{{ asset('images/placeholder.svg') }}" alt="No Image" style="width: 100px; height: auto; border-radius: 4px;">
                    @endif
                </td>
                <td>
                    <span class="badge" style="background-color: #e2e8f0; color: #1e293b; padding: 5px 10px; border-radius: 4px; font-weight: 500;">
                        {{ $product->product_category ?? 'No Category' }}
                    </span>
                </td>
                <td style="text-align: center;"><a href="{{ route('admin.updateproduct', $product->id) }}" style="color:green; font-weight: bold; text-decoration: none;">Update</a></td>
                <td style="text-align: center;">
                    <form action="{{ route('admin.deleteproduct', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:red; font-weight:bold; padding:0; cursor:pointer; font:inherit; text-decoration:none;">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
</div>

<div class="pagination-container">
    {{ $products->appends(request()->query())->links() }}
</div>

@endsection