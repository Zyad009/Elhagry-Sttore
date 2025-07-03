<div class="dropdown cart-dropdown">
    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        data-display="static">
        <i class="icon-shopping-cart"></i>
        {{-- عدد اللي في السلة --}}
        <span class="cart-count">{{$count}}</span>
        <span class="cart-txt">{{$totalPrice}} EGP</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-cart-products">
            @foreach ($data as $item )
            {{-- @dd($item) --}}
            <div class="product">
                <div class="product-cart-details">
                    <h4 class="product-title">
                        <a href="{{route('singel.product' , $item["slug"])}}">{{$item["name"]}}</a>
                    </h4>

                    <span class="cart-product-info">
                        <span class="cart-product-qty">{{$item["quantity"]}}</span>
                        x {{$item["final_price"]}} = {{$item["quantity"] * $item["final_price"]}} EGP
                    </span>
                </div><!-- End .product-cart-details -->

                <figure class="product-image-container">
                    <a href="{{route('singel.product' , $item["slug"])}}" class="product-image">
                        <img src="{{asset($item["image"])}}" alt="product">
                    </a>
                </figure>
                {{-- <livewire:front.cart.remove-cart-button :productSlug="$item->slug" /> --}}
                    <div>
                        <a href="#" wire:click.prevent='removeProduct("{{$item["key"]}}")' wire:loading.remove class="btn-remove" title="Remove Product"><i
                                class="icon-close"></i>
                            </a>
                            
                            <div class="spinner-border spinner-border-sm text-primary" wire:loading wire:target='removeProduct("{{$item["key"]}}")' role="status">
                                <span class="visually-hidden"></span>
                            </div>
                    </div>
            </div><!-- End .product -->
            @endforeach
        </div><!-- End .cart-product -->

        <div class="dropdown-cart-total">
            <span>Total</span>

            <span class="cart-total-price">{{$totalPrice}} EGP</span>
        </div><!-- End .dropdown-cart-total -->

        <div class="dropdown-cart-action">
            <a href="{{route('cart.view')}}" class="btn btn-outline-primary-2">View Cart</a>
            <a href="{{route('checkout')}}" class="btn btn-outline-primary-2"><span>Checkout</span><i
                    class="icon-long-arrow-right"></i></a>
        </div><!-- End .dropdown-cart-total -->
    </div>
    <!-- End .dropdown-menu -->
</div><!-- End .cart-dropdown -->

@push("front-js")
<script>
    window.addEventListener("errorIdCart", () => {
            Swal.fire({
            icon: "error",
            title: "Error!",
            text: "Don't play, Khalbous",
            showConfirmButton: false,
            timer: 3000
            });
            });
            
            window.addEventListener("successCart", () => {
            Swal.fire({
            icon: "success",
            title: "Success!",
            text: "add successfully",
            showConfirmButton: false,
            timer: 1500
            });
            });
            
            // window.addEventListener("removeProduct", () => {
            // Swal.fire({
            // icon: "success",
            // title: "Success!",
            // text: "Product Removed Successfully",
            // showConfirmButton: false,
            // timer: 1500
            // });
            // });
            
            window.addEventListener("productAlreadyInCart", () => {
            Swal.fire({
            icon: "warning",
            title: "Warning!",
            text: "The Product Already In Your Cart",
            showConfirmButton: false,
            timer: 4000
            });
            });
</script>
@endpush