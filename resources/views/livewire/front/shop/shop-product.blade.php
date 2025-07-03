@push('front-css')
<link rel="stylesheet" href="{{asset('front/assets2')}}/css/style.css">
@endpush
<main class="main">
    <div class="page-header text-center"
        style="background-image: url('{{asset('front/assets2')}}/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{$categoryName ?? $title}}<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">

                    <div class="mb-2"></div><!-- End .mb-2 -->

                    <div class="mb-4">
                        <input type="text" wire:model.live="search" class="form-control"
                            placeholder="Search products...">
                    </div>

                    <div class="products mb-3">
                        <div class="row justify-content-center">
                            @if ($products->count() > 0)
                            @foreach ($products as $product)
                            <div class="col-6 col-md-4 col-lg-5">
                                <div class="product product-7 text-center">
                                    <figure class="product-media">
                                            @php
                                            // if($product->offer?->discount_type == "percentage"){
                                            // $price = $product->price;
                                            // $discount = $product->offer?->discount;
                                            // $mark = "%";
                                            // $finalPrice = $price - (($price*$discount)/100);
                                            // }else{
                                            // $price = $product->price;
                                            // $discount = $product->offer?->discount;
                                            // $mark = "EGP";
                                            // $finalPrice = $price-$discount;
                                            // }
                                            $detailsPrice = $product->getFinalPriceDetails();
                                            @endphp
                                        @if (isset($product->offer))
                                        <span class="product-label label-sale">-{{$detailsPrice['discount'] . $detailsPrice['mark']}}</span>
                                        @endif

                                        <a href="{{ route('singel.product', $product) }}">
                                            <img id="current-image-{{$product->id}}"
                                                src="{{ asset($product->images->first()?->main_image) }}"
                                                alt="Product image" class="product-shop-image">
                                        </a>

                                        <div class="product-action-vertical">
                                            <a href="{{ route('singel.product', $product) }}"
                                                class="btn-product-icon btn-expandable"><span>View Details</span>
                                                <i class="la la-search"></i>
                                            </a>
                                        </div>
                                        <div class="product-action">
                                            <livewire:front.cart.add-cart-button :productSlug="$product->slug"/>
                                        </div>
                                    </figure><!-- End .product-media -->

                                    <div class="product-body">
                                        <div class="product-cat">
                                            <a href="#"
                                                wire:click.prevent="selectCategory('{{$product->category->slug}}' , '{{$product->category->name}}')">{{$product->category->name}}</a>
                                        </div><!-- End .product-cat -->
                                        <h3 class="product-title"><a
                                                href="{{ route('singel.product', $product) }}">{{$product->name}}</a>
                                        </h3>
                                        <!-- End .product-title -->
                                        <div class="product-price">
                                            @if (isset($product->offer))
                                            <span class="new-price">
                                                Now {{$detailsPrice['final']}} EGP
                                            </span>
                                            <span class="old-price"><s>{{$detailsPrice['original']}} EGP </s></span>
                                            @else
                                            <div class="product-price">{{$detailsPrice['final']}} EGP</div>
                                            @endif
                                        </div>

                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val" style="width: 54%;"></div>
                                                <!-- End .ratings-val -->
                                            </div><!-- End .ratings -->
                                            <span class="ratings-text">( 2 Reviews )</span>
                                        </div><!-- End .rating-container -->

                                        <div class="product-nav product-nav-thumbs">
                                            @php
                                            $images = $product->images->first()?->images;
                                            $images = json_decode($images);
                                            @endphp
                                            <a href="#" class="thumb-image"
                                                onclick="changeImage({{$product->id}},'{{ asset($product->images->first()?->main_image) }}'); return false;">
                                                <img src="{{ asset($product->images->first()?->main_image) }}"
                                                    alt="product desc">
                                            </a>
                                            <a href="#" class="thumb-image-l"
                                                onclick="changeImage({{$product->id}},'{{ asset($product->images->first()?->hover_image) }}'); return false;">
                                                <img src="{{ asset($product->images->first()?->hover_image) }}"
                                                    alt="product desc">
                                            </a>
                                            @foreach ($images as $image)
                                            <a href="#" class="thumb-image"
                                                onclick="changeImage({{$product->id}},'{{ asset($image) }}'); return false;">
                                                <img src="{{ asset($image) }}" alt="product desc">
                                            </a>
                                            @endforeach
                                        </div><!-- End .product-nav -->
                                    </div><!-- End .product-body -->
                                </div><!-- End .product -->
                            </div><!-- End .col-6 col-md-4 col-lg-4 -->
                            @endforeach
                            @else
                            <x-alert.fixed-alert.no-product />
                            @endif
                        </div><!-- End .row -->

                        {{ $products->links() }}

                    </div><!-- End .products -->
                    <!-- End .products -->


                </div><!-- End .col-lg-9 -->

                <aside class="col-lg-3 order-lg-first mb-2">
                    <div class="mb-3"></div><!-- End .mb-2 -->
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-collapsible">
                            <div class="mb-2">
                                <button wire:click="resetFilters" class="btn btn-sm btn-outline-danger w-100">Reset
                                    Filters</button>
                            </div>
                            <h3 class="widget-title ">
                                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true"
                                    aria-controls="widget-1">
                                    Categories
                                </a>
                            </h3><!-- End .widget-title -->

                            <!-- ✅ زرار Reset هنا فوق القائمة -->

                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count">
                                        @if ($categories->count() > 0)
                                        @foreach ($categories as $category)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <a href="#"
                                                    wire:click.prevent="selectCategory('{{$category->slug}}' , '{{$category->name}}')">{{$category->name}}</a>
                                            </div>
                                            <span class="item-count">{{$category->products_count}}</span>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@push('front-js')
<script>
    function changeImage( itemId ,imageSrc) {
            const currentImage = document.getElementById('current-image-' + itemId);
            currentImage.src = imageSrc;
        }
</script>
@endpush