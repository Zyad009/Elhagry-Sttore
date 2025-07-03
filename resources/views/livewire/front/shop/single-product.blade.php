
<form wire:submit.prevent="addToCart">
    <div class="details-filter-row details-row-size">
        <label for="size">Size:</label>
        <div class="select-custom">
            <select name="size" id="size" class="form-control" wire:model.live="selectedSize">
                <option value="">Select a size</option>
                @foreach ($details as $index => $item)
                <option value="{{ $index }}" wire:key="size-{{ $index }}">{{ $item['name'] }}</option>
                @endforeach
            </select>
            <x-message.error name="selectedSize" />
        </div>
    </div>

    <div class="details-filter-row details-row-size mt-3">
        <label for="color">Color:</label>
        <div class="select-custom">
            <select name="color" id="color" class="form-control" wire:model.live="selectedColor">
                <option value="">Select a color</option>
                @foreach ($details[$selectedSize]['colors'] ?? [] as $color)
                <option value="{{ $color['id'] }}" wire:key="color-{{ $color['id'] }}">{{ $color['name'] }}</option>
                @endforeach
            </select>
            <x-message.error name="selectedColor" />
        </div>
    </div>

<div class="details-filter-row details-row-size">
        <label for="qty">Qty:</label>
        <div class="product-details-quantity">
            <input type="number" wire:model='QTY' id="qty" class="form-control" value="1" min="1" step="1" data-decimals="0"
                required>
            <x-message.error name="QTY" />
        </div><!-- End .product-details-quantity -->
    </div><!-- End .details-filter-row -->

    <div class="mt-4">
        <button type="submit" class="btn btn-outline-primary-2 text-center">
            Add to Cart
        </button>
    </div>
</form>