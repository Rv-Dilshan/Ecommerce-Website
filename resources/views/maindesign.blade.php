<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  
  <link rel="shortcut icon" href="{{ asset('front_end/images/favicon.png') }}" type="image/x-icon">

  <title>Giftos</title>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front_end/css/bootstrap.css') }}" />
  <link href="{{ asset('front_end/css/style.css') }}" rel="stylesheet" />
  <link href="{{ asset('front_end/css/responsive.css') }}" rel="stylesheet" />
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <div class="hero_area">
    <header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="{{ route('index') }}">
          <span>Giftos</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav  ">
            <li class="nav-item {{ Route::is('index') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('index') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item {{ Route::is('shop') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('shop') }}">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Why Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Testimonial</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact">Contact Us</a>
            </li>
          </ul>
          <div class="user_option">
            @if(Auth::check())
            <a href="{{route('dashboard')}}">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span>Dashboard</span>
            </a>
            <a href="{{route('user.orders')}}">
              <i class="fa fa-list" aria-hidden="true"></i>
              <span>My Orders</span>
            </a>
            @else
            <a href="{{route('login')}}">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span>Login</span>
            </a>
            <a href="{{route('register')}}">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span>Sign Up</span>
            </a>
            @endif
            <a href="{{ Auth::check() ? route('cart.index') : route('login') }}" style="position:relative; display:inline-flex; align-items:center;">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              @auth
                @php $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity'); @endphp
                @if($cartCount > 0)
                <span style="position:absolute; top:-8px; right:-10px; background:#db6574; color:#fff; font-size:10px; font-weight:700; border-radius:50%; width:18px; height:18px; display:flex; align-items:center; justify-content:center; line-height:1;">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                @endif
              @endauth
            </a>
            <form class="form-inline ml-3" action="{{ route('index') }}" method="GET" style="position:relative; display:flex; align-items:center;">
              <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." style="border: 1px solid #e2e8f0; border-radius: 20px; padding: 6px 15px; font-size: 14px; outline: none; width: 180px; transition: width 0.3s;" onfocus="this.style.width='250px'" onblur="this.style.width='180px'">
              <button class="btn nav_search-btn" type="submit" style="position:absolute; right:5px; border:none; background:transparent; cursor:pointer; color:#64748b;">
                <i class="fa fa-search" aria-hidden="true"></i>
              </button>
            </form>
          </div>
        </div>
      </nav>
    </header>
    @if(Route::is('index'))
    <section class="slider_section">
      <div class="slider_container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box"> 
                      <h1>Welcome To Our <br> Gift Shop</h1>
                      <p>Sequi perspiciatis nulla reiciendis, rem, tenetur impedit, eveniet non necessitatibus error distinctio mollitia suscipit.</p>
                      <a href="#contact">Contact Us</a>
                    </div>
                  </div>
                  <div class="col-md-5 ">
                    <div class="img-box">
                      <img style="width:600px" src="{{ asset('front_end/images/image3.jpeg') }}" alt="" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif
  </div>

  <main>
    <div class="container mt-4">
        @if(session('cart_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px; background:#ecfdf5; color:#065f46; border:1px solid #6ee7b7; padding:14px 20px; font-weight:500; font-family:'Plus Jakarta Sans', sans-serif;">
                <i class="fa fa-check-circle" style="margin-right:8px;"></i> {{ session('cart_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none; background:transparent; border:none; float:right; font-size:20px; line-height:1; color:#000; opacity:0.5;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('cart_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:12px; background:#fde8e8; color:#9b1c1c; border:1px solid #fbd5d5; padding:14px 20px; font-weight:500; font-family:'Plus Jakarta Sans', sans-serif;">
                <i class="fa fa-exclamation-circle" style="margin-right:8px;"></i> {{ session('cart_error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none; background:transparent; border:none; float:right; font-size:20px; line-height:1; color:#000; opacity:0.5;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    @yield('index')
  </main>

  <section id="contact" class="contact_section ">
    <div class="container px-0">
      <div class="heading_container ">
        <h2>Contact Us</h2>
      </div>
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-lg-7 col-md-6 px-0">
          <div class="map_container">
            <div class="map-responsive">
              <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France" width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-5 px-0">
          @if(session('contact_success'))
            <div class="alert alert-success" style="border-radius:10px; background:#ecfdf5; color:#065f46; border:1px solid #6ee7b7; margin-bottom:20px;">
              <i class="fa fa-check-circle"></i> {{ session('contact_success') }}
            </div>
          @endif
          @if($errors->any())
            <div style="background:#fde8e8; color:#9b1c1c; border:1px solid #fbd5d5; border-radius:10px; padding:12px 16px; margin-bottom:15px; font-size:13px;">
              <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form action="{{ route('contact.submit') }}" method="POST">
            @csrf
            <div><input type="text" name="name" value="{{ old('name') }}" placeholder="Name" required /></div>
            <div><input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required /></div>
            <div><input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone" /></div>
            <div><textarea name="message" class="message-box" placeholder="Message" required style="width: 100%; border: none; height: 120px; margin-bottom: 25px; padding: 15px; background-color: #ffffff; outline: none; color: #101010; box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.05);">{{ old('message') }}</textarea></div>
            <div class="d-flex "><button type="submit">SEND</button></div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <br><br><br>

  <section class="info_section  layout_padding2-top">
    <div class="social_container">
      <div class="social_box">
        <a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a>
        <a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a>
        <a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a>
        <a href=""><i class="fa fa-youtube" aria-hidden="true"></i></a>
      </div>
    </div>
    <div class="info_container ">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3">
            <h6>ABOUT US</h6>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do...</p>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="info_form ">
              <h5>Newsletter</h5>
              <form action="#">
                <input type="email" placeholder="Enter your email">
                <button>Subscribe</button>
              </form>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>NEED HELP</h6>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do...</p>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>CONTACT US</h6>
            <div class="info_link-box">
              <a href=""><i class="fa fa-map-marker" aria-hidden="true"></i><span> Gb road 123 london Uk </span></a>
              <a href=""><i class="fa fa-phone" aria-hidden="true"></i><span>+01 12345678901</span></a>
              <a href=""><i class="fa fa-envelope" aria-hidden="true"></i><span> demo@gmail.com</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class=" footer_section">
      <div class="container">
        <p>© <span id="displayYear"></span> All Rights Reserved By <a href="https://html.design/">Web Tech Knowledge</a></p>
      </div>
    </footer>
  </section>

  <script src="{{ asset('front_end/js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('front_end/js/bootstrap.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="{{ asset('front_end/js/custom.js') }}"></script>
</body>

</html>