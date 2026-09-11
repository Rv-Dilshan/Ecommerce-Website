<!DOCTYPE html>
<html>
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dark Bootstrap Admin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    
    <link rel="stylesheet" href="{{ asset('/admin/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/css/font.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <link rel="stylesheet" href="{{ asset('/admin/css/style.default.css') }}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{ asset('/admin/css/custom.css') }}">
    <link rel="shortcut icon" href="{{ asset('/admin/img/favicon.ico') }}">
  </head>
  <body>
    <header class="header">   
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
          <div class="navbar-header">
            <a href="index.html" class="navbar-brand">
              <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Dark</strong><strong>Admin</strong></div>
              <div class="brand-text brand-sm"><strong class="text-primary">D</strong><strong>A</strong></div></a>
            <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
          </div>
          
          <div class="right-menu list-inline no-margin-bottom d-flex align-items-center">    
            <div class="list-inline-item">
              <form action="{{ route('admin.productsearch') }}" method="GET" class="form-inline">
                <div class="form-group mb-0">
                  <input type="search" name="search" class="form-control" placeholder="What are you searching for...." value="{{ request('search') }}">
                  <button type="submit" class="btn btn-primary ml-2">Search</button>
                </div>
              </form>
            </div>

            <div class="list-inline-item dropdown ml-3">
              <a id="navbarDropdownMenuLink1" href="http://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link messages-toggle"><i class="icon-email"></i><span class="badge dashbg-1">5</span></a>
            </div>

            <div class="list-inline-item logout ml-3"> 
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form> 
            </div>
          </div>
        </div>
      </nav>
    </header>
    
    <div class="d-flex align-items-stretch">
      <nav id="sidebar">
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="{{ asset('/admin/img/avatar-6.jpg') }}" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">Admin</h1>
            <p>E-Commerce</p>
          </div>
        </div>
        <span class="heading">Main</span>
        <ul class="list-unstyled">
          <li class="active"><a href="{{ route('dashboard') }}"> <i class="icon-home"></i>Home </a></li>
          <li><a href="#categoryDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Category </a>
            <ul id="categoryDropdown" class="collapse list-unstyled ">
              <li><a href="{{ route('admin.addcategory') }}">Add Category</a></li>
              <li><a href="{{ route('admin.viewcategory') }}">View Category</a></li>
            </ul>
          </li>
          <li><a href="#productDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Product </a>
            <ul id="productDropdown" class="collapse list-unstyled ">
              <li><a href="{{ route('admin.addproduct') }}">Add Product</a></li>
              <li><a href="{{ route('admin.viewproduct') }}">View Product</a></li>
            </ul>
          </li>
          <li><a href="{{ route('admin.vieworder') }}"> <i class="icon-padnote"></i>Orders </a></li>
          <li><a href="{{ route('admin.messages') }}"> <i class="icon-mail"></i>Messages </a></li>
        </ul>
      </nav>
      
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Dashboard</h2>
          </div>
        </div>
        
        <section class="no-padding-top no-padding-bottom">
         @yield('dashboard')
         @yield('add_category')
         @yield('view_category')
         @yield('update_category')
         @yield('add_product')
         @yield('view_product') 
         @yield('view_order')
         @yield('view_messages')
        </section>

        <footer class="footer">
          <div class="footer__block block no-margin-bottom">
            <div class="container-fluid text-center">
               <p class="no-margin-bottom">2026 &copy; Your company. Download From <a target="_blank" href="https://templateshub.net">Templates Hub</a>.</p>
            </div>
          </div>
        </footer>
      </div>
    </div>
    
    <script src="{{ asset('/admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/admin/vendor/popper.js/umd/popper.min.js') }}"> </script>
    <script src="{{ asset('/admin/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/admin/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('/admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('/admin/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/admin/js/charts-home.js') }}"></script>
    <script src="{{ asset('/admin/js/front.js') }}"></script>
  </body>
</html>