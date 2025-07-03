@extends("admin.layouts.app")
@section("admin-content")

        <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        {{-- <div cs="col-lg-8">
          <div class="row">las --}}

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">New Customer Service</h5>
                    <div class="inner">
                        <h4>To Add Customer Service</h4>
                        <p>|</p>
                    </div>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <a href="{{route("admin-dashboard.customer_s.new")}}">
                        <i class="bi bi-plus"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">All Customer Service</h5>
                    <div class="inner">
                        <h4>Show All Customer Service</h4>
                            <p>| all & delete & edit</p>
                    </div>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <a href="{{route("admin-dashboard.customer_s.all")}}">
                        <i class="bi bi-text-left"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Sales Card -->
      </div>
    </section>
    

@endsection