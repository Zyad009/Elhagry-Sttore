<header class="header header-6">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <ul class="top-menu top-link-menu d-none d-md-block">
                    <li>
                        <ul>
                            <li>
                                <a href="https://wa.me/201114656758" target="_blank">
                                    <i class="icon-whatsapp"></i>+201114656758
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul><!-- End .top-menu -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <div class="social-icons social-icons-color">
                    <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i
                            class="icon-facebook-f"></i></a>
                    <a href="#" class="social-icon social-instagram" title="Instagram" target="_blank"><i
                            class="icon-instagram"></i></a>
                </div><!-- End .soial-icons -->
                <ul class="top-menu top-link-menu">
                    <li>
                        <ul>
                            <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Login</a></li>
                        </ul>
                    </li>
                </ul><!-- End .top-menu -->

            </div><!-- End .header-right -->
        </div>
    </div>
    <div class="header-middle">
        <div class="container">

            <div class="header-left">
            </div>

            <div class="header-center">
                <a href="index.html" class="logo">
                    <img src="{{asset('front/assets')}}/images/demos/demo-6/logo.png" alt="Molla Logo" width="82"
                        height="20">
                </a>
            </div><!-- End .header-left -->

            <div class="header-right">

                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-display="static">
                        <i class="icon-shopping-cart"></i>
                        <span class="cart-count">2</span>
                        <span class="cart-txt">$ 164,00</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-cart-products">
                            <div class="product">
                                <div class="product-cart-details">
                                    <h4 class="product-title">
                                        <a href="product.html">Beige knitted elastic runner shoes</a>
                                    </h4>

                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">1</span>
                                        x $84.00
                                    </span>
                                </div><!-- End .product-cart-details -->

                                <figure class="product-image-container">
                                    <a href="product.html" class="product-image">
                                        <img src="{{asset('front/assets')}}/images/products/cart/product-1.jpg"
                                            alt="product">
                                    </a>
                                </figure>
                                <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                            </div><!-- End .product -->

                            <div class="product">
                                <div class="product-cart-details">
                                    <h4 class="product-title">
                                        <a href="product.html">Blue utility pinafore denim dress</a>
                                    </h4>

                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">1</span>
                                        x $76.00
                                    </span>
                                </div><!-- End .product-cart-details -->

                                <figure class="product-image-container">
                                    <a href="product.html" class="product-image">
                                        <img src="{{asset('front/assets')}}/images/products/cart/product-2.jpg"
                                            alt="product">
                                    </a>
                                </figure>
                                <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                            </div><!-- End .product -->
                        </div><!-- End .cart-product -->

                        <div class="dropdown-cart-total">
                            <span>Total</span>

                            <span class="cart-total-price">$160.00</span>
                        </div><!-- End .dropdown-cart-total -->

                        <div class="dropdown-cart-action">
                            <a href="cart.html" class="btn btn-primary">View Cart</a>
                            <a href="checkout.html" class="btn btn-outline-primary-2"><span>Checkout</span><i
                                    class="icon-long-arrow-right"></i></a>
                        </div><!-- End .dropdown-cart-total -->
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .cart-dropdown -->
            </div>
        </div><!-- End .container -->
    </div><!-- End .header-middle -->

    <div class="header-bottom sticky-header">
        <div class="container">
            <div class="header-left">

                @include('front.layouts.nav')

                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>
            </div><!-- End .header-left -->

            <div class="header-right">
                <i class="la la-lightbulb-o"></i>
                <p>Clearance Up to 30% Off</span></p>
            </div>
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->
</header><!-- End .header -->