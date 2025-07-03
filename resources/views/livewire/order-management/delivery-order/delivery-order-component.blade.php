<div>
    <div class="d-flex justify-content-between align-items-end gap-3 w-100 mt-3">
        <div class="d-flex gap-2 flex-grow-1 align-items-end">

            <div class="flex-grow-1">
                <input type="text" wire:model.live="search" class="form-control form-control-lg w-100"
                    placeholder="Search: Code & Phone">
            </div>

        </div>

    </div>

    <div class="card mx-auto my-4 px-3 py-2 w-100">
        <div class="table-responsive text-nowrap mt-2">

            <div class="mb-3 text-center">
                @foreach($status as $index => $name)
                <label style="margin-right: 20px; transform: scale(1.2); display: inline-flex; align-items: center;">
                    <input type="checkbox" class="status-filter" wire:model.live="statusFilters" value="{{ $index }}"
                        style="margin-right: 5px;">
                    {{ $name }}
                </label>
                @endforeach

                <label style="margin-left: 50px; transform: scale(1.2); display: inline-flex; align-items: center;">
                    <input type="checkbox" id="selectAll" onclick="checkAllStatuses()" style="margin-right: 5px;">
                    (dis&select All)
                </label>
            </div>
            @if (isset($orders) && count($orders) > 0)
            <table class="table" wire:poll.30s>

                <thead>
                    <tr>
                        <th class="text-center">Follow-Up Code</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Phone</th>
                        <th class="text-center">Details Items</th>
                        <th class="text-center">Details Order</th>
                        <th class="text-center">Fanil Price</th>
                        <th class="text-center">Date Time</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                    @forelse ($orders as $order)
                    @php
                    if( $highlightDelete == $loop->index){
                    $color = 'danger';
                    }else{
                    $color = null;
                    }
                    @endphp
                    <tr class="table-{{ $color }}">
                        <td><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                            <strong>{{ $order->follow_up_code}}</strong>
                        </td>

                        <td class="text-center">
                            {{$order->user->full_name}}
                        </td>

                        <td class="text-center">
                            {{$order->user->phone}}
                        </td>


                        <td class="text-center">
                            <a class="btn btn-sm "
                                wire:click.prevent="$dispatch('showOrderDetailsEvent', {id: '{{ $order->id }}' , mainStatus: '{{ $order->status_order }}' })">
                                <i class='bx bx-info-circle text-primary'></i> View Items
                            </a>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm" wire:click.prevent="$dispatch('showDetailsOrderEvent', {
                                {{-- phone: '{{ $order->phone }}',
                                whatsapp: '{{ $order->user->whatsapp }}',
                                name: '{{ $order->user->full_name }}',
                                address: '{{ $order->delivery_address }}',
                                mainPrice: '{{ $order->total }}',
                                discount: '{{ $order->total_discount }}',
                                deliveryPrice: '{{ $order->delivery_price }}',
                                finallyTotal: '{{ $order->finally_total }}',
                                orderCode: '{{ $order->follow_up_code }}',
                                status: '{{ $order->status_order }}',
                                nameCity: '{{ $order->city }}',
                                nameArea: '{{ $order->area }}',
                                deliveryType: '{{ $order->delivery_type }}', --}}
                                orderId: '{{ $order->id }}'

                                })">
                                <i class='bx bx-info-circle text-primary'></i> View Order
                            </a>
                        </td>

                        <td class="text-center">{{ $order->finally_total }} <span>EGP</span></td>
                        <td class="text-center">
                            <x-special-text.dark-text title="{{ $order->order_date }}" />
                        </td>

                        <td class="text-center">
                            @switch($order->status_order)
                            @case("pending")
                            <x-special-text.warning-text title="Pending" />
                            @break
                            @case("accepted")
                            <x-special-text.dark-text title="Accepted" />
                            @break
                            @case("out_for_delivery")
                            <x-special-text.primary-text title="Out Delivery" />
                            @break
                            @case("completed")
                            <x-special-text.success-text title="Completed" />
                            @break
                            @case("cancelled")
                            <x-special-text.danger-text title="Cancelled" />
                            @break
                            @default
                            <x-special-text.warning-text title="Pending" />
                            @endswitch
                        </td>

                        <td class="text-center">
                            <div class="d-flex flex-row gap-3 align-items-center text-white">
                                @if ( $indexId === -1 && $order->status_order == "pending")
                                <a wire:click.prevent="accepteOrder({{$order->id}})" class="btn btn-success px-3">
                                    <i class="bx bx-check-circle" wire:loading.remove wire:target='accepteOrder({{$order->id}})' ></i>
                                    <x-spinner.spinner title="accepteOrder({{$order->id}})"/>
                                </a>
                                @else
                                <a class="btn btn-secondary px-3">
                                    <i class="bx bx-check-circle"></i>
                                </a>
                                @endif

                                @if ( $indexId === -1 && $order->status_order == "accepted")
                                <a wire:click.prevent="outDeliveryOrder({{$order->id}})" class="btn btn-info px-3">
                                    <i class="bx bx-car" wire:loading.remove wire:target='outDeliveryOrder({{$order->id}})'></i>
                                    <x-spinner.spinner title="outDeliveryOrder({{$order->id}})"/>
                                </a>
                                @else
                                <a class="btn btn-secondary px-3">
                                    <i class="bx bx-car"></i>
                                    @endif

                                    @if ( $indexId === -1 && $order->status_order == "out_for_delivery")
                                    <a wire:click.prevent="completedOrder({{$order->id}})" class="btn btn-primary px-3">
                                        <i class="bx bx-check-double" wire:loading.remove wire:target='completedOrder({{$order->id}})'></i>
                                        <x-spinner.spinner title="completedOrder({{$order->id}})"/>
                                    </a>
                                    @else
                                    <a class="btn btn-secondary px-3">
                                        <i class="bx bx-check-double"></i>
                                        @endif

                                        @if (  $order->status_order == "completed" || $order->status_order == "cancelled" || $indexId !== -1 )
                                        <a class="btn btn-secondary px-3">
                                            <i class="bx bx-trash" ></i>
                                        </a>
                                        @else
                                        <a wire:click.prevent="cancele({{ $loop->index }})"
                                            class="btn btn-danger px-3 text-white">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                        @endif
                            </div>
                        </td>
                    </tr>
                    @if ($loop->index == $indexId)
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="border rounded p-3 my-3 bg-light">
                                <div class="row g-2 align-items-stretch">
                                    <!-- Textarea -->
                                    <div class="col-md-8 d-flex flex-column">
                                        <label class="form-label fw-bold">Reason for Deletion</label>
                                        <textarea wire:model="deleteReason" class="form-control h-100" rows="1"
                                            placeholder="Enter reason for deleting this order"></textarea>
                                        <x-message.error name="deleteReason" />
                                    </div>

                                    <!-- Cancel Button -->
                                    <div class="col-md-2 d-flex flex-column justify-content-end">
                                        <label class="form-label fw-bold invisible">Cancel</label>
                                        <button class="btn btn-primary w-100 h-100" wire:click='canceleRemove'>
                                            <i class="bx bx-x" wire:loading.remove wire:target='canceleRemove'></i>
                                            <x-spinner.spinner title="canceleRemove" />
                                        </button>
                                    </div>

                                    <!-- Delete Button -->
                                    <div class="col-md-2 d-flex flex-column justify-content-end">
                                        <label class="form-label fw-bold invisible">Delete</label>
                                        <button class="btn btn-danger w-100 h-100"
                                            wire:click='removeOrder({{$order->id}})'>
                                            <i class="bx bx-trash" wire:loading.remove wire:target='removeOrder'></i>
                                            <x-spinner.spinner title="removeOrder" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No Orders found</td>
                    </tr>
                    @endforelse
                </tbody>
                <h5 class="text-center">" Total: {{ $orders->total() }} "</h5>
            </table>
            @else
            <div class="text-center">
                <div class="alert alert-danger text-center" role="alert">This Order Not Found!</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $orders->links() }}
    </div>

    <script>
        function checkAllStatuses() {
            const checkboxes = document.querySelectorAll('.status-filter');
            const selectAll = document.getElementById('selectAll');
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            // Optional: Trigger 'change' event if needed by your framework
            checkboxes.forEach(cb => cb.dispatchEvent(new Event('change')));
        }
    </script>
</div>