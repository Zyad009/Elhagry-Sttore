<div class="card mx-auto my-4 px-3 py-2 w-100">
    <div class="table-responsive text-nowrap mt-2">
        @if (!empty($items) && count($items) > 0)

{{$slot}}
@else
                <div class="text-center">
                    <div class="alert alert-danger text-center" role="alert"> There Is Absolutely Nothing!</div>
                </div>
                @endif
    </div>
</div>