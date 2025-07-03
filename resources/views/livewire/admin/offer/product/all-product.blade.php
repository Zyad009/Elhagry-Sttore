<div>
    <div class="d-flex justify-content-between align-items-end gap-3 w-100 mt-3">
        <div class="d-flex gap-2 flex-grow-1 align-items-end">

            <div class="flex-grow-1">
                <input type="text" wire:model.live="search" class="form-control form-control-lg w-100"
                    placeholder="Search: Name , Category">
            </div>

        </div>

        <div>
            <a href="{{ route('admin-dashboard.offer.new') }}" class="btn btn-primary btn-lg">
                <i class='bx bx-plus bx-tada'></i> Create Main Offer
            </a>
        </div>
    </div>

    <div class="card mx-auto my-4 px-3 py-2 w-100">
        <div class="table-responsive text-nowrap mt-2">

            @if (count($products) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Has Offer</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">After Discount</th>
                        <th class="text-center">QTY</th>
                        <th class="text-center">Select Offer</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }} || </td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i> <strong>{{ $product->name
                                }}</strong></td>
                        <td class="text-center">
                            @if (isset($product->category))
                            {{$product->category->name}}
                            @else
                            <b class="badge bg-label-danger me-1">No Category</b>
                            @endif
                        </td>
                        <td class="text-center">{{ $product->price }} <span>EGP</span></td>

                        <td class="text-center">
                            @if($product->offer?->name)
                            <x-special-text.primary-text title="{{ $product->offer->name}}(main) ">
                            </x-special-text.primary-text>

                            @elseif($product->offer?->name == null && $product->offer?->discount )
                            <x-special-text.primary-text title="{{ $product->offer->name }}(Special)">
                            </x-special-text.primary-text>
                            @else
                            <x-special-text.dark-text title="No Offer"></x-special-text.dark-text>
                            @endif
                        </td>


                        <td class="text-center">
                            @if ($product->offer?->discount_type == "percentage")
                            {{$product->offer?->discount}}
                            <x-special-text.success-text title="%"/>
                            @elseif ($product->offer?->discount_type == "value")
                            {{$product->offer?->discount}}
                            <x-special-text.warning-text title="EGP"/>
                            @else
                            <x-special-text.dark-text title="No Offer"></x-special-text.dark-text>
                            @endif
                        </td>

                        <td class="text-center">
                            @php
                            if($product->offer?->discount_type == "percentage"){
                            $price = $product->price;
                            $discount = $product->offer?->discount;
                            $result = $price - (($price*$discount)/100);
                            echo $result ." EGP";
                            }elseif($product->offer?->discount_type == "value"){
                            $price = $product->price;
                            $discount = $product->offer?->discount;
                            $result = $price-$discount;
                            echo $result ." EGP";
                            }else{
                            echo "<b class='badge bg-label-dark me-1 fw-bold'>No Change</b>";
                            }
                            @endphp
                        </td>

                        <td class="text-center">
                            @if($product->QTY == 0)
                            <b class="badge bg-label-danger me-1 fw-bold">{{ $product->QTY }}</b>
                            @elseif($product->QTY <= 5) <b class="badge bg-label-warning me-1">{{ $product->QTY }}</b>
                                @else
                                {{ $product->QTY }}
                                @endif
                        </td>



                        <td class="text-center">
                            <select wire:model="selectedOffer.{{$product->id}}" class="form-control">
                                <option value="">Main Offer</option>
                                @foreach ($this->offers as $offer)
                                <option value="{{$offer->id}}" wire.key="offer-{{$offer->id}}">{{$offer->name}}</option>
                                @endforeach
                            </select>
                        </td>

                        <td class="text-center">
                            <div class="d-flex flex-row gap-3 align-items-center text-white">
                                <a wire:click.prevent="setOffer({{$product->id}})" class="btn btn-success px-3">
                                    Add
                                </a>

                                <a class="btn btn-primary text-white"
                                    wire:click.prevent='$dispatch("createOffer", {id: {{$product->id}} })'>
                                    Add Special Offer
                                </a>

                                <a wire:click.prevent="cancelle({{$product->id}})"
                                    class="btn btn-danger px-3 text-white">
                                    Cancelle
                                </a>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
                <h5 class="text-center">" Total: {{ $products->total() }} "</h5>
            </table>
            @else
            <div class="text-center">
                <div class="alert alert-danger text-center" role="alert">This Product Not Found!</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $products->links() }}
    </div>
</div>