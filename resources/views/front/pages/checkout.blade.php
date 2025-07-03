@extends("front.layouts.app")
@section('front-title', 'Checkout')
@push("front-cdn")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@section("front-content")

<main class="main">
    <div class="page-header text-center"
        style="background-image: url('{{ asset('front/assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Checkout<span>page</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <div class="page-content">
        <div class="checkout">
            <div class="container">
                <div class="checkout-discount">

                </div><!-- End .checkout-discount -->
                <livewire:front.check-out />
            </div><!-- End .container -->
        </div><!-- End .checkout -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@push("front-js")
<script>
    window.addEventListener("errorPlay", () => {
				            Swal.fire({
				            icon: "error",
				            title: "Error!",
				            text: "please do not play again",
				            showConfirmButton: false,
				            timer: 2000
				            });
				            });
</script>
@endpush

@endsection