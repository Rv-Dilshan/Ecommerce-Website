@extends('admin.maindesign')

@section('dashboard')
     <div class="container-fluid">
            <div class="row">
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-user-1"></i></div><strong>Total Customers</strong>
                    </div>
                    <div class="number dashtext-1">{{ $totalUsers }}</div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: {{ $totalUsers > 0 ? 100 : 0 }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-windows"></i></div><strong>Total Products</strong>
                    </div>
                    <div class="number dashtext-2">{{ $totalProducts }}</div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: {{ $totalProducts > 0 ? 100 : 0 }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-padnote"></i></div><strong>Total Orders</strong>
                    </div>
                    <div class="number dashtext-3">{{ $totalOrders }}</div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: {{ $totalOrders > 0 ? 100 : 0 }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-bill"></i></div><strong>Total Revenue (Paid)</strong>
                    </div>
                    <div class="number dashtext-4">${{ number_format($totalRevenue, 2) }}</div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: {{ $totalRevenue > 0 ? 100 : 0 }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection