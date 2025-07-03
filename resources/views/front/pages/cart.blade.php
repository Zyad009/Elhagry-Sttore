@extends('front.layouts.app')
@section('front-title', 'Shopping Cart')

@push('front-css')
<link rel="stylesheet" href="{{ asset('front/assets/css/custom.css') }}">
@endpush

@push("front-cdn")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section("front-content")
<main class="main">
    <div class="page-header text-center"
        style="background-image: url('{{ asset('front/assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Shopping Cart <span>page</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <!-- Optional breadcrumb content -->
        </div>
    </nav>


    @if (session('cart') !=null && count(session('cart')) > 0)
    @php $cartItems = session('cart'); @endphp

    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <!-- Cart Table -->
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($cartItems) --}}

                                @foreach ($cartItems as $item)
                                <tr data-key="{{ $item['key'] }}">
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="#">
                                                    <img src="{{ asset($item['image']) }}" alt="Product image">
                                                </a>
                                            </figure>
                                            <h3 class="product-title">
                                                <a href="#">{{$item['name']}}</a>
                                            </h3>
                                        </div>
                                    </td>
                                    {{-- @dd($item) --}}
                                    <td class="price-col book-price">{{ $item['final_price'] }} EGP</td>
                                    <td class="quantity-col">
                                        <div class="cart-product-quantity">
                                            <input type="number" class="form-control quantity-input"
                                                value="{{ $item['quantity'] }}" min="1"
                                                max="{{$item['max_quantity'] ?? 1}}">
                                        </div>
                                    </td>
                                    <td class="total-col total-price">{{ $item['final_price'] * $item['quantity'] }} EGP
                                    </td>
                                    <td class="remove-col">
                                        <button class="btn-remove"><i class="icon-close"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Cart Summary -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total Without Shipping</h3>
                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>
                                            @php
                                            $subtotal = 0;
                                            foreach ($cartItems as $item) {
                                            $subtotal += $item['price'] * $item['quantity'];
                                            }
                                            @endphp
                                            {{ $subtotal }} EGP
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{ route('checkout') }}"
                                class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO
                                CHECKOUT</a>
                        </div>
                        <a href="{{route('shop')}}" class="btn btn-outline-dark-2 btn-block mb-3">
                            <span>CONTINUE SHOPPING</span><i class="icon-refresh"></i>
                        </a>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="text-danger">**** Your cart is empty ****</h2>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary-2">Continue Shopping</a>
                </div>
            </div>
        </div>
        @endif
</main>

@push('front-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cartRows = document.querySelectorAll('.table-cart tbody tr');

				function updateCartTotal() {
				let subtotal = 0;
				// نحدث قيمة الـ subtotal عن طريق حساب المجموع النهائي لجميع المنتجات المتبقية
				document.querySelectorAll('.table-cart tbody tr').forEach(row => {
				const totalCol = row.querySelector('.total-price');
				const price = parseFloat(totalCol.textContent.replace('EGP', '').trim()) || 0;
				subtotal += price;
				});

				// نحدث السعر الكلي داخل الـ DOM مباشرة
				const summarySubtotal = document.querySelector('.summary-subtotal td:last-child');
				if (summarySubtotal) {
				summarySubtotal.textContent = `${subtotal.toFixed(2)} EGP`; // نعرض المجموع النهائي مع تنسيق
				}
				}
        // تحديث الكمية لما تتغير
        cartRows.forEach(row => {
            const quantityInput = row.querySelector('.quantity-input');
            const priceCol = row.querySelector('.book-price');
            const totalCol = row.querySelector('.total-price');
            const key = row.dataset.key;

            quantityInput.addEventListener('change', function () {
                let quantity = parseInt(this.value);
                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                    this.value = 1;
                }

                const unitPrice = parseFloat(priceCol.textContent.replace('EGP', '').trim());
                const total = unitPrice * quantity;
                totalCol.textContent = `${total.toFixed(2)} EGP`;

                updateCartTotal();

                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: "PUT",
                    data: {
                        _token: '{{ csrf_token() }}',
                        key: key,
                        quantity: quantity
                    },
                });
            });
        });


        document.querySelectorAll('.btn-remove').forEach(button => {
            button.addEventListener('click', function () {
                const row = this.closest('tr');
                const key = row.dataset.key;

                $.ajax({
                    url: "{{ route('cart.delete') }}",
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        key: key
                    },
                    success: function (res) {
                        row.remove();	
                        updateCartTotal();

                        if (document.querySelectorAll('.table-cart tbody tr').length === 0) {
                            document.querySelector('.cart').innerHTML = `
                                <div class="text-center py-5">
                                    <h2 class="text-danger">**** Your cart is empty ****</h2>
                                    <a href="{{ route('home') }}" class="btn btn-outline-primary-2 mt-3">Continue Shopping</a>
                                </div>
                            `;
                        }

                        console.log(res.message);
                    }
                });
            });
        });

        updateCartTotal();
    });
</script>
@endpush
@endsection