<x-models.show title="Order Details :-">
    <div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Customer Name</label>
                <div class="form-control bg-light">{{ $name }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Order Status</label>
                <div class="form-control bg-light">{{ $status }}</div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Order Code</label>
                <div class="form-control bg-light">{{ $orderCode }}</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Phone Number</label>
                <div class="form-control bg-light">{{ $phone }}</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Whatsapp</label>
                <div class="form-control bg-light">{{ $whatsapp }}</div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">City</label>
                <div class="form-control bg-light">{{ $nameCity }}</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Area</label>
                <div class="form-control bg-light">{{ $nameArea }}</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Delivery Type</label>
                <div class="form-control bg-light">{{ $deliveryType }}</div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Main Price</label>
                <div class="form-control bg-light">{{ $mainPrice }}</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Discount</label>
                <div class="form-control bg-light">{{ $discount }}</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Delivery Price</label>
                <div class="form-control bg-light">{{ $deliveryPrice }}</div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Total</label>
            <div class="form-control bg-light">{{ $finallyTotal }}</div>
        </div>


    <div class="border rounded p-3 my-3 bg-light">
        <div class="row align-items-end mb-3">
            <div class="col-md-4">
                <label class="form-label">City</label>
                <select wire:model.live="selectedCity" class="form-select border border-warning">
                    @foreach ($cities as $city)
                    <option value="{{ $city->id }}" @selected(old($orderCityId) == $city->id) wire:key='city-{{$city->id}}'>{{ $city->name }}</option>
                    @endforeach
                </select>
                <x-message.error name="selectedCity" />
            </div>
            <div class="col-md-4">
                <label class="form-label">Area</label>
                <select wire:model.live="selectedArea" class="form-select border border-warning">
                    @foreach ($areas as $area)
                    <option value="{{ $area->id }}" @selected(old($orderAreaId) == $area->id) wire:key='area-{{$area->id}}'>{{ $area->name }}</option>
                    @endforeach
                </select>
                <x-message.error name="selectedArea" />
            </div>
            <div class="col-md-4">
                <label class="form-label">Price Delivery</label>
                <select wire:model.live="selectedDeliveryprice" class="form-select border border-warning">
                    <option value="{{$deliveryType}}" selected> {{$deliveryPrice}} EGP </option>                        
                    @if ($deliveryType == 'regular')
                        <option value="super" selected> {{$priceDeliveryServiceSuper}} EGP</option>
                        @else
                        <option value="regular" selected> {{$priceDeliveryServiceRegular}} EGP </option>                        
                    @endif
                </select>
                <x-message.error name="selectedDelivery"/>
            </div>
        </div>

        <div class="row align-items-end mb-3">
            <div class="col-md-4">
                <label class="form-label">Building</label>
                <input type="number" min="0" max="9999" wire:model="building" class="form-control border border-warning">
                <x-message.error name="building" />
            </div>
            <div class="col-md-4">
                <label class="form-label">Floor</label>
                <input type="number" min="0" max="999" wire:model="floor" class="form-control border border-warning">
                <x-message.error name="floor" />
            </div>
            <div class="col-md-4">
                <label class="form-label">Apartment</label>
                <input type="number" min="0" max="999" wire:model="apartment" class="form-control border border-warning">
                <x-message.error name="apartment" />
            </div>
        </div>

        <div class="row align-items-end mb-3">
            <div class="col-md-8">
                <label class="form-label">Address</label>
                <textarea wire:model="address" rows="1" class="form-control border border-warning"
                    placeholder="Enter new address here">{{$address}}</textarea>
                <x-message.error name="address" />
            </div>
            <div class="col-md-4">
                <button wire:click="updateAddress" class="btn btn-success mt-4">
                    <i class="bx bx-save"></i> Save
                </button>
            </div>
        </div>
    </div>
    </div>
</x-models.show>