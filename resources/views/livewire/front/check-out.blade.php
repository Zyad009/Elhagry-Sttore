<form wire:submit.prevent="submit" novalidate>
    <div class="row">
        <div class="col-lg-9">
            <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
            <div class="row">
                <div class="col-sm-6">
                    <label>First Name <span class="text-danger">*</label>
                    <input type="text" class="form-control" wire:model.blur="first_name" required>
                    <x-message.error name="first_name"></x-message.error>
                </div><!-- End .col-sm-6 -->

                <div class="col-sm-6">
                    <label>Last Name <span class="text-danger">*</label>
                    <input type="text" class="form-control" wire:model.blur="last_name" required>
                    <x-message.error name="last_name"></x-message.error>
                </div><!-- End .col-sm-6 -->
                <div class="col-sm-6">
                    <label>Email <span class="text-danger">*</label>
                    <input type="email" class="form-control" wire:model.blur="email" required>
                    <x-message.error name="email"></x-message.error>
                </div><!-- End .col-sm-6 -->
                <div class="col-sm-6">
                    <label>Phone <span class="text-danger">*</label>
                    <input type="tel" class="form-control" wire:model.blur="phone" required>
                    <x-message.error name="phone"></x-message.error>
                </div><!-- End .col-sm-6 -->

                <div class="col-sm-6">
                    <label>Whatsapp (optional)</label>
                    <input type="tel" class="form-control" wire:model.blur="whatsapp" required>
                    <x-message.error name="whatsapp"></x-message.error>
                </div><!-- End .col-sm-6 -->

                <div class="col-sm-6">
                    <label>Delivery Method <span class="text-danger">*</label>
                    <select wire:model.live="deliveryMethod" class="form-control">
                        <option value="">Select Delivery Method</option>
                        <option value="pickup">Pickup</option>
                        <option value="delivery">Delivery</option>
                    </select>
                    <x-message.error name="deliveryMethod"></x-message.error>
                </div><!-- End .col-sm-6 -->

                @if ($deliveryMethod == 'delivery')


                <div class="col-sm-12">
                    <label>Choose Delivery Address <span class="text-danger">*</span></label>
                    <select wire:model.live="selectedDeliveryAddress" class="form-control">
                        <option value="">Select Address</option>
                        <option value='new'>(Add New Address)</option>
                        @foreach ($addresses as $address)
                        <option value='{{$address->id}}'> {{ $address->address }} </option>
                        @endforeach
                    </select>
                    <x-message.error name="selectedDeliveryAddress"></x-message.error>
                </div>

                @if ( $selectedDeliveryAddress == 'new' )
                <div class="col-sm-6">
                    <label>City <span class="text-danger">*</label>
                    <select wire:model.live="selectedCity" class="form-control">
                        <option value="">Select City</option>
                        @foreach ($cities as $city )
                        <option value="{{$city->id}}" wire:key='city-{{$city->id}}'>{{$city->name}}</option>
                        @endforeach
                    </select>
                    <x-message.error name="selectedCity"></x-message.error>
                </div><!-- End .col-sm-6 -->

                <div class="col-sm-6">
                    <label>Area <span class="text-danger">*</label>
                    <select wire:model.live="selectedArea" class="form-control">
                        <option value="">Select Area</option>
                        @foreach ($areas as $area )
                        <option value="{{$area->id}}" wire:key='area-{{$area->id}}'>{{$area->name}}</option>
                        @endforeach
                    </select>
                    <x-message.error name="selectedArea"></x-message.error>
                </div><!-- End .col-sm-6 -->


                <div class="col-sm-6">
                    <label>Building <span class="text-danger">*</label>
                    <input type="number" wire:model='building' min="0" max="9999" class="form-control">
                    <x-message.error name="building"></x-message.error>
                </div><!-- End .col-sm-6 -->

                <div class="col-sm-6">
                    <label>Floor <span class="text-danger">*</label>
                    <input type="number" wire:model='floor' min="0" max="9999" class="form-control">
                    <x-message.error name="floor"></x-message.error>
                </div><!-- End .col-sm-6 -->

                <div class="col-sm-6">
                    <label>Apartment <span class="text-danger">*</label>
                    <input type="number" wire:model='apartment' min="0" max="999999" class="form-control">
                    <x-message.error name="apartment"></x-message.error>
                </div><!-- End .col-sm-6 -->

                <div class="col-sm-12">
                    <label>Delivery Address <span class="text-danger">*</label>
                    <textarea class="form-control" wire:model.blur='address' cols="30" rows="4"
                        placeholder="House number and Street name"></textarea>
                </div><!-- End .col-sm-6 -->
                @endif

                <div class="col-sm-6">
                    <label>Choose Delivery Service <span class="text-danger">*</label>
                    <select wire:model.live="selectedDeliveryService" class="form-control">
                        <option value="">Select Delivery Service</option>
                        @if ($priceDeliveryServiceRegular)
                        <option value="regular">Normal Price : {{$priceDeliveryServiceRegular}} EGP </option>
                        <option value="super">Super Price : {{$priceDeliveryServiceSuper}} EGP</option>
                        @endif
                    </select>
                    <x-message.error name="selectedDeliveryService"></x-message.error>
                </div><!-- End .col-sm-6 -->

                @elseif($deliveryMethod == 'pickup')
                <div class="col-sm-12">
                    <label>Pickup Location <span class="text-danger">*</label>
                    <select wire:model.live="pickupLocation" class="form-control">
                        <option value="">Select Pickup Location</option>
                        @foreach ($pickupPoints as $point )
                        <option value="{{$point->id}}" wire:key='point-{{$point->id}}'>{{$point->name}}</option>
                        @endforeach
                    </select>
                    <x-message.error name="pickupLocation"></x-message.error>
                </div><!-- End .col-sm-6 -->
                @endif
            </div><!-- End .row -->
            <div class="row">
                <div class="col-sm-6">
                    <label>Payment Method <span class="text-danger">*</label>
                    <select wire:model="paymentMethod" class="form-control">
                        <option value="">Selected Payment Method</option>
                        <option value="cash">Cash</option>
                    </select>
                    <x-message.error name="paymentMethod"></x-message.error>
                </div><!-- End .col-sm-6 -->

                <div class="col-sm-6">
                    <label class="d-block font-weight-bold">Coming Soon - Visa Payment</label>
                    <div class="border rounded p-3 d-flex align-items-center" style="background-color: #f4f4f4;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa Logo"
                            style="height:30px; margin-right: 10px;">
                        <span style="font-weight: 500; font-size: 14px; color: #555;">Visa payment option will be
                            available soon.</span>
                    </div>
                </div>
            </div><!-- End .row -->

            <label>Order notes (optional)</label>
            <textarea class="form-control" wire:model.blur='notes' cols="30" rows="4"
                placeholder="Notes about your order, e.g. special notes for delivery">
            </textarea>
            <x-message.error name="notes"></x-message.error>
        </div><!-- End .col-lg-9 -->
        <aside class="col-lg-3">
            <div class="summary">
                <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

                <table class="table table-summary">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cart as $item)
                        <tr>
                            <td> {{$item['name'] ." " .($item['quantity'])}}</td>
                            <td>{{$item['final_price']*$item['quantity']}} EGP</td>
                        </tr>
                        @endforeach
                        <tr class="summary-subtotal">
                            <td>Subtotal:</td>
                            <td>{{$subTotal}} EGP</td>
                        </tr><!-- End .summary-subtotal -->
                        <tr>
                            <td>Shipping: {{$deliveryType}}</td>
                            <td>{{$priceDelivery ?? "0.00"}} EGP</td>
                        </tr>
                        <tr class="summary-total">
                            <td>Total:</td>
                            <td>{{$total}} EGP</td>
                        </tr><!-- End .summary-total -->
                    </tbody>
                </table><!-- End .table table-summary -->


                <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                    <span class="btn-text">Place Order</span>
                    <span class="btn-hover-text">Proceed to Checkout</span>
                </button>
            </div><!-- End .summary -->
        </aside><!-- End .col-lg-3 -->
    </div><!-- End .row -->
</form>