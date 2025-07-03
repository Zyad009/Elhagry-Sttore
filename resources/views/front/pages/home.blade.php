@section('front-title', 'Home')
@extends('front.layouts.app')
@section('front-content')

<main class="main">

    <div class="intro-slider-container">
        <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl" data-owl-options='{
                "dots": false,
                "nav": false, 
                "responsive": {
                    "992": {
                        "nav": true
                    }
                }
            }'>
            <div class="intro-slide" style="background-image: url({{asset('front/assets')}}/images/demos/demo-6/slider/slide-1.jpg);">
                <div class="container intro-content text-center">
                    <h3 class="intro-subtitle text-white">You're Looking Good</h3>
                    <!-- End .h3 intro-subtitle -->
                    <h1 class="intro-title text-white">New Lookbook</h1><!-- End .intro-title -->

                    <a href="category.html" class="btn btn-outline-white-4">
                        <span>Discover More</span>
                    </a>
                </div><!-- End .intro-content -->
            </div><!-- End .intro-slide -->

        </div><!-- End .intro-slider owl-carousel owl-theme -->

        <span class="slider-loader"></span><!-- End .slider-loader -->
    </div><!-- End .intro-slider-container -->

    <div class="pt-2 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="banner banner-overlay">
                        <a href="#">
                            <img src="{{asset('front/assets')}}/images/demos/demo-6/banners/banner-1.jpg" alt="Banner">
                        </a>

                        <div class="banner-content banner-content-center">
                            <h4 class="banner-subtitle text-white"><a href="#">New in</a></h4>
                            <!-- End .banner-subtitle -->
                            <h3 class="banner-title text-white"><a href="#"><strong>Women’s</strong></h3>
                            <!-- End .banner-title -->
                            <a href="#" class="btn btn-outline-white banner-link underline">Shop Now</a>
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col-sm-6 -->

                <div class="col-sm-6">
                    <div class="banner banner-overlay">
                        <a href="#">
                            <img src="{{asset('front/assets')}}/images/demos/demo-6/banners/banner-2.jpg" alt="Banner">
                        </a>

                        <div class="banner-content banner-content-center">
                            <h4 class="banner-subtitle text-white"><a href="#">New in</a></h4>
                            <!-- End .banner-subtitle -->
                            <h3 class="banner-title text-white"><a href="#"><strong>Men’s</strong></a></h3>
                            <!-- End .banner-title -->
                            <a href="#" class="btn btn-outline-white banner-link underline">Shop Now</a>
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col-sm-6 -->
            </div><!-- End .row -->
            <hr class="mt-0 mb-0">
        </div><!-- End .container -->
    </div><!-- End .bg-gray -->

    <div class="mb-5"></div><!-- End .mb-5 -->
    <div class="container">
        <div class="heading heading-center mb-3">
            <h2 class="title">Best Seller</h2><!-- End .title -->
        </div><!-- End .heading -->

        <div class="tab-content tab-content-carousel">
            <div class="tab-pane p-0 fade show active" id="trending-all-tab" role="tabpanel"
                aria-labelledby="trending-all-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                        "nav": false, 
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "480": {
                                "items":2
                            },
                            "768": {
                                "items":3
                            },
                            "992": {
                                "items":4
                            },
                            "1200": {
                                "items":4,
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'>
                    @forelse ( $productsBest as $item)

                    <div class="product product-7 text-center">
                        @php
                        $details = $item->getFinalPriceDetails();
                        @endphp
                        <figure class="product-media">
                            @if ($details['discount'] > 0)
                            <span class="product-label label-sale">-{{$details['discount'] . $details['mark']}}</span>
                            @endif
                            <a href="{{route('single.product' , $item)}}">
                                <img src="{{ asset($item->images->first()?->main_image) }}" alt="Product image" class="product-image">
                                <img id="current-image-best-{{$item->id}}" src="{{ asset($item->images->first()?->hover_image) }}"
                                    alt="Product image" class="product-image product-image-hover">
                            </a>
                    
                            <div class="product-action-vertical">
                                <a href="{{route('single.product' , $item)}}" class="btn-product-icon btn-expandable"><span>View
                                        Details</span>
                                    <i class="la la-search"></i>
                                </a>
                            </div><!-- End .product-action-vertical -->
                            <div class="product-action">
                                <livewire:front.cart.add-cart-button :productSlug="$item->slug" />
                            </div>
                        </figure><!-- End .product-media -->
                    
                        <div class="product-body">
                            <div class="product-cat">
                                {{-- <a href="{{route('shop' , $item->category->slug)}}">{{$item->category->name}}</a>
                                --}}
                                <a href="{{route('shop' , ['category'=>$item->category->slug])}}">{{$item->category->name}}</a>
                                {{--
                                <livewire:front.home.select-category-component :categorySlug="$item->category->slug"
                                    :categoryName="$item->category->name" /> --}}
                    
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="{{ route('single.product', $item) }}">{{$item->name}}</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                @if (isset($item->offer))
                                <span class="new-price">
                                    Now {{$details['final']}} EGP
                                </span>
                                <span class="old-price"><s>{{$details['original']}} EGP </s></span>
                                @else
                                <div class="product-price">{{$details['final']}} EGP</div>
                                @endif
                            </div><!-- End .product-price -->
                    
                            <div class="product-nav product-nav-thumbs">
                                @php
                                $images = $item->images->first()?->images;
                                $images = json_decode($images);
                                @endphp
                                <a href="{{route('single.product' , $item)}}" class="active">
                                    <img src="{{ asset($item->images->first()?->main_image) }}" alt="product desc">
                                </a>
                    
                                <a href="#" class="thumb-image"
                                    onclick="changeImageBest({{$item->id}} ,'{{ asset($item->images->first()?->hover_image) }}'); return false;">
                                    <img src="{{ asset($item->images->first()?->hover_image) }}" alt="product desc">
                                </a>
                                @foreach ($images as $image)
                                <a href="#" class="thumb-image"
                                    onclick="changeImageBest({{$item->id}} ,'{{ asset($image) }}'); return false;">
                                    <img src="{{ asset($image) }}" alt="product desc">
                                </a>
                                @endforeach
                            </div><!-- End .product-nav -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    @empty
                    @endforelse
                    </div><!-- End .owl-carousel -->
                    @if($productsBest->isEmpty())
                    <x-alert.fixed-alert.no-product />
                    @endif


                {{-- </div><!-- End .owl-carousel --> ممكن تتشال --}}
            </div><!-- .End .tab-pane -->
        </div><!-- End .tab-content -->
    </div><!-- End .container -->

    <div class="mb-5"></div><!-- End .mb-5 -->

    <div class="pt-4 pb-3" style="background-color: #222;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-truck"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title"> Delivery</h3><!-- End .icon-box-title -->
                            <p>super delivery</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-3 col-sm-6 -->

                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-rotate-left"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Return & Refund</h3><!-- End .icon-box-title -->
                            <p>Easy returns</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-3 col-sm-6 -->

                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-unlock"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Secure Payment</h3><!-- End .icon-box-title -->
                            <p>100% secure payment</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-3 col-sm-6 -->

                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-headphones"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Quality Support</h3><!-- End .icon-box-title -->
                            <p>Alway online feedback 24/7</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-3 col-sm-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .bg-light pt-2 pb-2 -->

    <div class="mb-6"></div><!-- End .mb-5 -->

    <div class="container">
        <h2 class="title text-center mb-4">New Arrivals</h2><!-- End .title text-center -->

        <div class="products">
            <div class="row justify-content-center">
                @forelse ( $productsNew as $item)
                <div class="col-6 col-md-4 col-lg-3">
                    @php
                    $details = $item->getFinalPriceDetails();
                    @endphp
                
                    <div class="product product-7 text-center">
                        <figure class="product-media">
                            @if ($details['discount'] > 0)
                            <span class="product-label label-sale">-{{$details['discount'] . $details['mark']}}</span>
                            @endif
                            <a href="{{route('single.product' , $item)}}">
                                <img src="{{ asset($item->images->first()?->main_image) }}" alt="Product image" class="product-image">
                                <div id="main-image">
                                    <img id="current-image-new-{{$item->id}}" src="{{ asset($item->images->first()?->hover_image) }}"
                                        alt="Product image" class="product-image product-image-hover">
                                </div>
                            </a>
                
                            <div class="product-action-vertical">
                                <a href="{{route('single.product' , $item)}}" class="btn-product-icon btn-expandable"><span>View
                                        Details</span>
                                    <i class="la la-search"></i>
                                </a>
                            </div><!-- End .product-action-vertical -->
                            <div class="product-action">
                                <livewire:front.cart.add-cart-button :productSlug="$item->slug" />
                            </div>
                        </figure><!-- End .product-media -->
                
                        <div class="product-body">
                            <div class="product-cat">
                                <a href="{{route('shop' , ['category'=>$item->category->slug])}}">{{$item->category->name}}</a>
                                {{-- <a href="{{route('shop' , $item->category->slug)}}">{{$item->category->name}}</a>
                                --}}
                                {{--
                                <livewire:front.home.select-category-component :categorySlug="$item->category->slug"
                                    :categoryName="$item->category->name" />--}}
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="{{ route('single.product', $item) }}">{{$item->name}}</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                @if (isset($item->offer))
                                <span class="new-price">
                                    Now {{$details['final']}} EGP
                                </span>
                                <span class="old-price"><s>{{$details['original']}} EGP </s></span>
                                @else
                                <div class="product-price">{{$details['final']}} EGP</div>
                                @endif
                            </div><!-- End .product-price -->
                
                            <div class="product-nav product-nav-thumbs">
                                @php
                                $images = $item->images->first()?->images;
                                $images = json_decode($images);
                                @endphp
                                <a class="thumb-image active">
                                    <img src="{{ asset($item->images->first()?->main_image) }}" alt="product desc">
                                </a>
                                <a href="#" class="thumb-image"
                                    onclick="changeImageNew({{$item->id}} ,'{{ asset($item->images->first()?->hover_image) }}'); return false;">
                                    <img src="{{ asset($item->images->first()?->hover_image) }}" alt="product desc">
                                </a>
                                @foreach ($images as $image)
                                <a href="#" class="thumb-image"
                                    onclick="changeImageNew({{$item->id}} ,'{{ asset($image) }}'); return false;">
                                    <img src="{{ asset($image) }}" alt="product desc">
                                </a>
                                @endforeach
                            </div><!-- End .product-nav -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                </div>
                @empty
                
                <x-alert.fixed-alert.no-product />
                
                @endforelse
            </div><!-- End .row -->
        </div><!-- End .products -->

        <div class="more-container text-center mt-2">
            <a href="{{route('shop')}}" class="btn btn-outline-dark-2 btn-more"><span>show more</span></a>
        </div><!-- End .more-container -->
    </div><!-- End .container -->
</main><!-- End .main -->

@push('front-js')
<script>
    function changeImageNew( itemId ,imageSrc) {
            const currentImage = document.getElementById('current-image-new-' + itemId);
            currentImage.src = imageSrc;
        }

        function changeImageBest( itemId ,imageSrc) {
            const currentImage = document.getElementById('current-image-best-' + itemId);
            currentImage.src = imageSrc;
        }
</script>
@endpush
@endsection