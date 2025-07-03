<div>
    <div class="d-flex justify-content-between align-items-end gap-3 w-100 mt-3">
        <div class="d-flex gap-2 flex-grow-1 align-items-end">
            <div class="flex-grow-1">
                <label for="searchBy" class="form-label">
                    <h5>Search By: </h5>
                </label>
                <select wire:model="searchBy" id="searchBy" class="form-select form-select-lg w-80">
                    <option value="name">Name</option>
                    <option value="size">Size</option>
                    <option value="category">Category</option>
                    <option value="color">Color</option>
                </select>
            </div>

            <div class="flex-grow-1">
                <input type="text" wire:model.live="search" class="form-control form-control-lg w-100"
                    placeholder="Search Here">
            </div>

            <div>
                <button type="button" wire:click="resetFilters" class="btn btn-secondary btn-lg">
                    <i class="bx bx-reset"></i> Reset
                </button>
            </div>
        </div>

        <div>
            <a href="{{ route('admin-dashboard.product.new') }}" class="btn btn-primary btn-lg">
                <i class='bx bx-plus bx-tada'></i> Create
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
                        <th class="text-center">Description</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Has Offer</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">After Discount</th>
                        <th class="text-center">QTY</th>
                        <th class="text-center">Image</th>
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

                        <td class="text-center">
                            {{ str()->limit($product->description, 20, ' ...') }}
                            <a class="btn btn-sm "
                                wire:click.prevent="$dispatch('showDescriptionEvent', {description: '{{ $product->description }}' })">
                                <i class='bx bx-info-circle'></i> View
                            </a>
                        </td>

                        <td class="text-center">{{ $product->price }} <span>EGP</span></td>

                        <td class="text-center">
                            @if($product->offer?->name)
                            <x-special-text.primary-text title="{{ $product->offer->name}}(main) ">
                            </x-special-text.primary-text>

                            @elseif($product->offer?->name == null && $product->offer?->discount )
                            <x-special-text.primary-text title="(Special)">
                            </x-special-text.primary-text>
                            @else
                            <x-special-text.dark-text title="No Offer"></x-special-text.dark-text>
                            @endif
                        </td>


                        <td class="text-center">
                            @if ($product->offer?->discount_type == "percentage")
                            %{{$product->offer?->discount}}
                            @elseif ($product->offer?->discount_type == "value")
                            EGP {{$product->offer?->discount}}
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
                            <b class="badge bg-label-danger me-1">{{ $product->QTY }}</b>
                            @elseif($product->QTY <= 5) <b class="badge bg-label-warning me-1">{{ $product->QTY }}</b>
                                @else
                                {{ $product->QTY }}
                                @endif
                        </td>

                        <td class="text-center">
                            <img src="{{ asset($product->images->first()?->main_image ?? config(" default-image.image")
                                ) }}" class="product-image" alt="product">
                        </td>
                        <td class="text-center">
                            <div class="d-flex flex-row gap-2 align-items-center">
                                <a href="{{ route('admin-dashboard.product.edit', $product) }}"
                                    class="btn btn-icon btn-outline-warning">
                                    <i class="bx bx-pencil"></i>
                                </a>

                                <a class="btn btn-icon btn-outline-secondary"
                                    wire:click.prevent='$dispatch("showProductEvent" , {id: {{$product->id}} })'>
                                    <i class='bx bx-show'></i>
                                </a>

                                <form action="{{ route('admin-dashboard.product.delete', $product) }}" method="post"
                                    data-confirm-delete="true" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-icon btn-outline-danger confirm-delete">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
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