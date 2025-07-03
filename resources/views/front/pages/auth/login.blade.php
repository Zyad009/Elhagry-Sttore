@extends("front.layouts.app")
@section("front-title" , "Login")
@section("content.front")

<main class="main">
    <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
        style="background-image: url('{{asset(" front/assets2")}}/images/backgrounds/login-bg.jpg')">
        <div class="container">
            <div class="form-box">
                <div class="form-tab">
                    <ul class="nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab"
                                aria-controls="signin-2" aria-selected="true">Sign In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="register-tab-2" data-toggle="tab" href="#register-2" role="tab"
                                aria-controls="register-2" aria-selected="false">Register</a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        {{-- Login --}}


                        <div class="tab-pane fade show active" id="signin-2" role="tabpanel"
                            aria-labelledby="signin-tab-2">
                            <livewire:auth.login>
                                <a href="{{route('forgot.password.index')}}" class="forgot-link">Forgot Your
                                    Password?</a>
                                {{-- forgate password --}}

                                <div class="form-choice">
                                    <p class="text-center">or sign in with</p>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="{{route('auth.social.redirect' , " google")}}"
                                                class="btn btn-login btn-g">
                                                <i class="icon-google"></i>
                                                Login With Google
                                            </a>
                                        </div><!-- End .col-6 -->
                                        <div class="col-sm-6">
                                            <a href="{{route('auth.social.redirect' , " facebook")}}"
                                                class="btn btn-login btn-f">
                                                <i class="icon-facebook-f"></i>
                                                Login With Facebook
                                            </a>
                                        </div><!-- End .col-6 -->
                                    </div><!-- End .row -->
                                </div><!-- End .form-choice -->
                                <br>
                                <div class="text-center">
                                    </p>
                                </div>
                        </div><!-- .End .tab-pane -->


                        {{-- Register --}}



                        <div class="tab-pane fade " id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
                            <livewire:auth.register>

                                <div class="form-choice">
                                    <p class="text-center">or sign in with</p>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="{{route('auth.social.redirect' , " google")}}"
                                                class="btn btn-login btn-g">
                                                <i class="icon-google"></i>
                                                Login With Google
                                            </a>
                                        </div><!-- End .col-6 -->
                                        <div class="col-sm-6">
                                            <a href="{{route('auth.social.redirect' , " facebook")}}"
                                                class="btn btn-login btn-f">
                                                <i class="icon-facebook-f"></i>
                                                Login With Facebook
                                            </a>
                                        </div><!-- End .col-6 -->
                                    </div><!-- End .row -->
                                </div><!-- End .form-choice -->

                        </div><!-- .End .tab-pane -->
                    </div><!-- End .tab-content -->
                </div><!-- End .form-tab -->
            </div><!-- End .form-box -->
        </div><!-- End .container -->
    </div><!-- End .login-page section-bg -->
</main><!-- End .main -->

@endsection