<x-models.xlarge title="{{ $title }} :-">
    @if ($data)
    {{-- @if ()
        
    @endif --}}
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Size</th>
                <th class="text-center">Colour</th>
                <th class="text-center">QTY</th>
                <th class="text-center">Discount For 1</th>
                <th class="text-center">Final Price For (T)</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $singleProduct)
            @php
            if( $highlightDelete == $loop->index){
            $color = 'danger';
            }elseif($highlightEdit == $loop->index){
            $color = 'primary';
            }else{
            $color = 'default';
            }
            @endphp
            <tr class="table-{{$color}}">
                <td class="text-center">{{ $singleProduct->product_name }}</td>

                <td class="text-center">
                    @if( $key == $singleProduct->id.'&'.$singleProduct->order_id)
                    <select wire:model.live="selectedSize" class="form-control">
                        <option value="">Size</option>
                        @foreach ($productDetails as $index => $size)
                        <option value="{{ $index }}" wire:key="size-{{ $index }}">{{ $size['name'] }}</option>
                        @endforeach
                    </select>
                    <x-message.error name="selectedSize" />
                    @else
                    {{ $singleProduct->size }}
                    @endif
                </td>

                <td class="text-center">
                    @if( $key == $singleProduct->id.'&'.$singleProduct->order_id)
                    <select wire:model.live='selectedColor' class="form-control">
                        <option value="">Color</option>
                        @foreach ($productDetails[$selectedSize]['colors'] ?? [] as $color )
                        <option value="{{ $color['id'] }}" wire:key="color-{{ $color['id'] }}">{{ $color['name'] }}
                        </option>
                        @endforeach
                    </select>
                    <x-message.error name="selectedColor" />
                    @else
                    {{ $singleProduct->color }}
                    @endif
                </td>

                <td class="text-center">
                    @if( $key == $singleProduct->id.'&'.$singleProduct->order_id )
                    <input type="number" wire:model='Qty' class="form-control" min="1" step="1" data-decimals="0"
                        required max="{{ $productDetails[$selectedSize]['colors'][$selectedColor]['QTY'] ?? 0 }}">
                    <x-message.error name="Qty" />
                    @else
                    {{ $singleProduct->QTY }}
                    @endif
                </td>

                <td class="text-center">{{ $singleProduct->discount }}</td>
                <td class="text-center">{{ $singleProduct->final_price }}</td>

                <td class="text-center">
                    @if ($singleProduct->QTY != 0 && $mainStatus == "accepted")
                    @if ( $close != true && $mainStatus == "accepted" )
                    <button
                        wire:click='editItem({{ $singleProduct->id}} , {{$singleProduct->order_id}} , "{{$singleProduct->slug}}",{{$loop->index}})'
                        class="btn btn-outline-primary" wire:key="edit-button-{{ $loop->index }}">
                        <i class="bx bx-edit" wire:loading.remove
                            wire:target='editItem({{ $singleProduct->id }}, {{ $singleProduct->order_id }}, "{{ $singleProduct->slug }}", {{ $loop->index }})'></i>
                        <x-spinner.spinner
                            title='editItem({{ $singleProduct->id }}, {{ $singleProduct->order_id }}, "{{ $singleProduct->slug }}", {{ $loop->index }})' />
                    </button>
                    @else
                    <button class="btn btn-secondary " disabled>
                        <i class="bx bx-edit"></i>
                    </button>
                    @endif
                    @else
                    <button class="btn btn-secondary " disabled>
                        <i class="bx bx-edit"></i>
                    </button>
                    @endif
                </td>
                <td class="text-center">
                    @if ($singleProduct->QTY != 0 && $mainStatus == "accepted")
                    @if ($close != true && $mainStatus == "accepted")
                    <button class="btn btn-danger confirm-delete" wire:click='deleteItem(
                        "{{$singleProduct->slug}}" ,
                        "{{$singleProduct->order_id}}" , 
                        {{$singleProduct->QTY}} , 
                        "{{$singleProduct->color}}",
                        "{{$singleProduct->size}}",
                        "{{$loop->index}}"
                        )'>
                        <i class="bx bx-trash" wire:loading.remove wire:target='deleteItem(
                        "{{$singleProduct->slug}}" ,
                        "{{$singleProduct->order_id}}" , 
                        {{$singleProduct->QTY}} , 
                        "{{$singleProduct->color}}",
                        "{{$singleProduct->size}}",
                        "{{$loop->index}}"
                        )'></i>
                        <x-spinner.spinner title='deleteItem(
                        "{{$singleProduct->slug}}" ,
                        "{{$singleProduct->order_id}}" , 
                        {{$singleProduct->QTY}} ,
                        "{{$singleProduct->color}}",
                        "{{$singleProduct->size}}", 
                        "{{$loop->index}}"
                        )' />
                    </button>
                    @else
                    <button class="btn btn-secondary " disabled>
                        <i class="bx bx-trash"></i>
                    </button>
                    @endif
                    @else
                    <button class="btn btn-secondary " disabled>
                        <i class="bx bx-trash"></i>
                    </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($deleteKey == $secritKey )
    <div class="border rounded p-3 my-3 bg-light">
        <div class="row g-2 align-items-stretch">
            <div class="col-md-5 d-flex flex-column">
                <label class="form-label fw-bold">Reason Delete</label>
                <textarea wire:model='reasonDelete' class="form-control form-control-sm flex-grow-1"
                    placeholder="reason delete"></textarea>
                <x-message.error name="reasonDelete" />
            </div>

            <div class="col-md-3 d-flex flex-column">
                <label class="form-label fw-bold">QTY</label>
                <input type="number" wire:model="QTYDelete" min="0" max="{{$maxDeletedQTY}}"
                    class="form-control form-control-sm w-100 h-100" placeholder="QTY">
                <x-message.error name="QTYDelete" />
            </div>

            <div class="col-md-2 d-flex flex-column justify-content-end">
                <label class="form-label fw-bold invisible">Cancel</label>
                <button class="btn btn-danger btn-sm w-100 h-100" wire:click='canceleDelete'>
                    <i class="bx bx-x" wire:loading.remove wire:target='canceleDelete'></i>
                    <x-spinner.spinner title="canceleDelete" />
                </button>
            </div>

            <div class="col-md-2 d-flex flex-column justify-content-end">
                <label class="form-label fw-bold invisible">Delete</label>
                <button class="btn btn-danger btn-sm w-100 h-100" wire:click='removeItem'>
                    <i class="bx bx-trash" wire:loading.remove wire:target='removeItem'></i>
                    <x-spinner.spinner title="removeItem" />
                </button>
            </div>
        </div>
    </div>
    @endif

    @if($key)
    <div class="border rounded p-3 my-3 bg-light">
        <div class="row g-2 align-items-stretch">
            <div class="col-md-8 d-flex flex-column">
                <label class="form-label fw-bold">Reason Edit</label>
                <textarea wire:model='reasonEdit' class="form-control form-control-sm flex-grow-1"
                    placeholder="reason edit"></textarea>
                <x-message.error name="reasonEdit" />
            </div>

            <div class="col-md-2 d-flex flex-column justify-content-end">
                <label class="form-label fw-bold invisible">Cancel</label>
                <button class="btn btn-primary btn-sm w-100 h-100" wire:click='canceleEdit'>
                    <i class="bx bx-x" wire:loading.remove wire:target='canceleEdit'></i>
                    <x-spinner.spinner title="canceleEdit" />
                </button>
            </div>

            <div class="col-md-2 d-flex flex-column justify-content-end">
                <label class="form-label fw-bold invisible">Save Changes</label>
                <button wire:click="saveChanges" class="btn btn-success btn-sm w-100 h-100">
                    <i class="bx bx-save" wire:loading.remove wire:target='saveChanges'></i>
                    <x-spinner.spinner title="saveChanges" />
                </button>
            </div>
        </div>
    </div>
    <div class="text-end mt-3">

    </div>
    @endif

    @elseif ($data)
    <div class="text-center p-4">
        <div class="alert alert-warning" role="alert">
            <h6 class="alert-heading fw-bold mb-1">This product does not have any quantities of different sizes and
                colors !!</h6>
            <br>
            if you want add quantities click here
            <a href="{{ route(" admin-dashboard.single-product.add", ["singleProduct"=> $data->slug]) }}"
                class="btn rounded-pill btn-danger btn-sm">
                Add Details
            </a>
        </div>
    </div>
    @endif
</x-models.xlarge>