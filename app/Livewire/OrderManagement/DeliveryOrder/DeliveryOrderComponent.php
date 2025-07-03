<?php

namespace App\Livewire\OrderManagement\DeliveryOrder;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Mail\Order\CanceledMail;
use App\Models\ProductColorSize;
use App\Mail\Order\CompletedMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Order\AcceptedDeliveryMail;

class DeliveryOrderComponent extends Component
{
    use WithPagination;


    protected $listeners = ["dataRefresh" => '$refresh'];

    #[Url(except: '')]
    public $search;
    
    public $statusFilters = [];
    public $status = [] ;
    public $highlightDelete = -1 , $deleteReason , $indexId = -1;

    public function mount()
    {
        $this->status = [
            "pending" => "Pending",
            "accepted" => "Accepted",
            "out_for_delivery" => "Out Delivery",
            "completed" => "Completed",
            "cancelled" => "Cancelled",
        ];

        $this->resetPage();
        // $saleOfficer = auth()->guard('saleOfficer')->user();
        // $this->pickupPointId =  $saleOfficer->pickup_point_id;
    }

    public function updatingStatusFilters()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function accepteOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $order->update([
            "status_order" => "accepted",
        ]);
        $this->dispatch('$refresh');
        Mail::to($order->user->email)->send(new AcceptedDeliveryMail ($order));
        return;
    }
    
    public function outDeliveryOrder($id)
    {
        Order::where('id', $id)->update([
            "status_order" => "out_for_delivery",
        ]);
        $this->dispatch('$refresh');
        return;
    }

    public function completedOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $order->update([
            "status_order" => "completed",
        ]);
        
        $this->dispatch('$refresh');
        Mail::to($order->user->email)->send(new CompletedMail($order));
        return;
    }

    public function paymentSuccess($id)
    {
        Order::where('id', $id)->update([
            "status" => 1,
            "status_order" => "completed",
        ]);
        $this->dispatch('$refresh');
        $this->dispatch('paymentSuccess');
        alert()->success('Success', 'Payment Has Been Successfully');
        return;
    }

    public function cancele($indexId)
    {

        $this->indexId = $indexId;
        $this->highlightDelete = $indexId;
    }

    public function canceleRemove()
    {
        $this->indexId = -1;
        $this->highlightDelete = -1;
        $this->deleteReason = null;
        $this->resetValidation();
    }

    public function removeOrder($id)
    {

        $this->validate([
            'deleteReason' => 'required|string|max:500|min:3',
        ]);

        $order = Order::where('id', $id)->with("orderDetails")->first();
        $order->update([
            "status_order" => "cancelled",
            "cancel_reason" => $this->deleteReason,
            "status" => 0,
        ]);

        $details = $order->orderDetails;

        $arr = [];
        foreach ($details as $item) {

            $arr[$item['slug']] = ($arr[$item['slug']] ?? 0) + $item['QTY'];

            ProductColorSize::whereHas("product", function ($q) use ($item) {
                $q->where("slug", $item['slug']);
            })
                ->whereHas("color", function ($q) use ($item) {
                    $q->where("name", $item['color']);
                })
                ->whereHas("size", function ($q) use ($item) {
                    $q->where("name", $item['size']);
                })
                ->increment('QTY', $item['QTY']);
        }

        foreach ($arr as $slug => $qty) {
            $this->dispatch('reasonCancel');

            Product::where('slug', $slug)->update([
                'QTY' => DB::raw("QTY + $qty"),
                'sold' => DB::raw("sold - $qty"),
            ]);
        }

        $this->indexId = -1;
        $this->highlightDelete = -1;
        $this->deleteReason = null;
        $this->resetValidation();
        $this->dispatch('$refresh');
        Mail::to($order->user->email)->send(new CanceledMail($order));
        $this->dispatch('cancelleSuccess');
    }



    public function render()
    {
        $orders = Order::where('delivery_method', 'delivery')
            ->when(!empty($this->statusFilters), function ($q) {
                $q->whereIn('status_order', $this->statusFilters);
            })
            ->when(empty($this->statusFilters), function ($q) {
                $q->where('status_order', 'pending');
                $q->orderByDesc('order_date');
            })
            ->where(function ($q) {
                $q->where('follow_up_code', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $this->search . '%');
            })
            ->with('user')
            ->orderByRaw("FIELD(status_order,'pending' ,'accepted','out_for_delivery' ,'completed', 'cancelled')")
            ->paginate(config('pagination.count'));

        return view('livewire.order-management.delivery-order.delivery-order-component' , compact('orders'));
    }
}
