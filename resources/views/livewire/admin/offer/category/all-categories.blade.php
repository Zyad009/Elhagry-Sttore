<div>
    <div class="d-flex justify-content-between align-items-end gap-3 w-100 mt-3">
        <div class="d-flex gap-2 flex-grow-1 align-items-end">

            <div class="flex-grow-1">
                <input type="text" wire:model.live="search" class="form-control form-control-lg w-100"
                    placeholder="Search: Name ">
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

            @if (count($categories) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Has QTY Prorduct</th>
                        <th class="text-center">Has Offer</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">Select Offer</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }} || </td>
                        <td class="text-center"><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                            <strong>{{ $category->name
                                }}</strong></td>

                        <td class="text-center">
                            <x-special-text.primary-text title="{{ $category->products_count }}"/>
                        </td>

                        <td class="text-center">

                            @if($category->offer?->name)
                            <x-special-text.primary-text title="{{ $category->offer->name}} ">
                            </x-special-text.primary-text>
                            @else
                            <x-special-text.dark-text title="No Offer"></x-special-text.dark-text>
                            @endif
                        </td>


                        <td class="text-center">
                            @if ($category->offer?->discount_type == "percentage")
                            %{{$category->offer?->discount}}
                            @elseif ($category->offer?->discount_type == "value")
                            EGP {{$category->offer?->discount}}
                            @else
                            <x-special-text.dark-text title="No Offer"></x-special-text.dark-text>
                            @endif
                        </td>

                        <td class="text-center">
                            <select wire:model="selectedOffer.{{$category->id}}" class="form-control">
                                <option value="">Main Offer</option>
                                @foreach ($this->offers as $offer)
                                <option value="{{$offer->id}}" wire.key="offer-{{$offer->id}}">{{$offer->name}}</option>
                                @endforeach
                            </select>

                        </td>

                        <td class="text-center">
                            <div class="d-flex flex-row gap-2 align-items-center text-white">
                                <a wire:click.prevent="setOffer({{$category->id}})" class="btn btn-success px-3">
                                    Add
                                </a>

                                <a wire:click.prevent="cancelle({{$category->id}})"
                                    class="btn btn-danger px-3 text-white">
                                    Cancelle
                                </a>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No categories found</td>
                    </tr>
                    @endforelse
                </tbody>
                <h5 class="text-center">" Total: {{ $categories->total() }} "</h5>
            </table>
            @else
            <div class="text-center">
                <div class="alert alert-danger text-center" role="alert">This category Not Found!</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $categories->links() }}
    </div>
</div>