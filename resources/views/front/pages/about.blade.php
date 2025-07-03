@extends('front.layouts.app')
@section("front-content")


<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('front/assets')}}/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">About us <span>Page</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <div class="page-content pb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="about-text text-center mt-3">
                        <h2 class="title text-center mb-2">Who We Are</h2><!-- End .title text-center mb-2 -->
                        <p>Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit
                            nunc tortor eu nibh. Suspendisse potenti. Sed egestas, ante et vulputate volutpat, uctus
                            metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id,
                            est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. </p>
                    </div><!-- End .about-text -->
                </div><!-- End .col-lg-10 offset-1 -->
            </div><!-- End .row -->

        </div><!-- End .container -->

        <div class="mb-2"></div><!-- End .mb-2 -->



        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="brands-text text-center mx-auto mb-6">
                        <h2 class="title">The world's premium design brands in one destination.</h2><!-- End .title -->
                        <p>Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus
                            id, mattis vel, nis</p>
                    </div><!-- End .brands-text -->

                </div><!-- End .col-lg-10 offset-lg-1 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection