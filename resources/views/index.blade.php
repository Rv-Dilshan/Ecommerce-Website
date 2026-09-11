@extends('maindesign')
@section('index')

  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Latest Products</h2>
      </div>
      <!-- Filter Categories -->
      <div style="display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin-bottom:30px;">
        <a href="{{ route('index') }}" style="padding:8px 20px; border-radius:20px; font-size:14px; font-weight:600; text-decoration:none; transition:0.2s; {{ !request('category') ? 'background:#0f172a; color:#fff;' : 'background:#f1f5f9; color:#64748b;' }}">
            All Products
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('index', ['category' => $cat->category, 'search' => request('search')]) }}" style="padding:8px 20px; border-radius:20px; font-size:14px; font-weight:600; text-decoration:none; transition:0.2s; {{ request('category') == $cat->category ? 'background:#0f172a; color:#fff;' : 'background:#f1f5f9; color:#64748b;' }}">
            {{ $cat->category }}
        </a>
        @endforeach
      </div>

      <!-- Search Context -->
      @if(request('search') || request('category'))
      <div style="margin-bottom:20px; text-align:center; color:#64748b; font-size:15px;">
        Showing results 
        @if(request('search')) for <strong>"{{ request('search') }}"</strong> @endif 
        @if(request('category')) in category <strong>{{ request('category') }}</strong> @endif
        <a href="{{ route('index') }}" style="color:#db6574; margin-left:10px; text-decoration:none;"><i class="fa fa-times-circle"></i> Clear Filters</a>
      </div>
      @endif

      <div class="row">
        @forelse($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
          <div class="box">
            <a href="{{ route('user.productdetails', $product->id) }}">
              <div class="img-box">
                @if($product->product_image)
                  <img src="{{ asset('images/' . $product->product_image) }}" alt="{{ $product->product_title }}" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}';">
                @else
                  <img src="{{ asset('images/placeholder.svg') }}" alt="{{ $product->product_title }}">
                @endif
              </div>
              <div class="detail-box">
                <h6>{{ $product->product_title }}</h6>
                <h6>Price <span>${{ number_format($product->product_price, 2) }}</span></h6>
              </div>
              <div class="new">
                <span>New</span>
              </div>
            </a>
            @if($product->product_quantity !== null && $product->product_quantity <= 0)
            <div style="padding: 0 10px 12px;">
              <button disabled style="width:100%; background:#f1f5f9; color:#94a3b8; border:1px solid #e2e8f0; border-radius:8px; padding:9px; font-size:13px; font-weight:600; cursor:not-allowed; display:flex; align-items:center; justify-content:center; gap:6px;">
                <i class="fa fa-exclamation-circle"></i> Out of Stock
              </button>
            </div>
            @else
              @auth
              <form action="{{ route('cart.add', $product->id) }}" method="POST" style="padding: 0 10px 12px;">
                @csrf
                <button type="submit" style="width:100%; background:#0f172a; color:#fff; border:none; border-radius:8px; padding:9px; font-size:13px; font-weight:600; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; transition: background 0.2s;" onmouseover="this.style.background='#db6574'" onmouseout="this.style.background='#0f172a'">
                  <i class="fa fa-shopping-bag"></i> Add to Cart
                </button>
              </form>
              @else
              <div style="padding: 0 10px 12px;">
                <a href="{{ route('login') }}" style="display:block; width:100%; background:#f1f5f9; color:#64748b; border:none; border-radius:8px; padding:9px; font-size:13px; font-weight:600; cursor:pointer; text-align:center; text-decoration:none;">
                  <i class="fa fa-shopping-bag"></i> Login to Buy
                </a>
              </div>
              @endauth
            @endif
          </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fa fa-search" style="font-size:48px; color:#cbd5e1; margin-bottom:15px;"></i>
            <h4 style="color:#1e293b; font-weight:700;">No products found</h4>
            <p style="color:#64748b;">Try adjusting your search or filters.</p>
        </div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div style="margin-top: 30px; display:flex; justify-content:center;">
        {{ $products->links() }}
      </div>
      <div class="btn-box">
        <a href="">View All Products</a>
      </div>
    </div>
  </section>

@endsection