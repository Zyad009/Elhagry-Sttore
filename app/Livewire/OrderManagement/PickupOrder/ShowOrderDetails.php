<?php
namespace App\Livewire\OrderManagement\PickupOrder;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use App\Models\OrderDetails;
use App\Livewire\OrderManagement\DeliveryOrder\DeliveryOrderComponent;


class ShowOrderDetails extends Component
{

    public $title , $data , $productDetails , $product , $mainStatus;
    public $reasonDelete, $QTYDelete , $maxDeletedQTY;
    public $reasonEdit, $selectedSize, $selectedColor , $Qty , $itemEdited , $close = false;
    public $slug, $color, $size, $orderId;
    public $key = null , $deleteKey , $secritKey;
    public $highlightDelete = null , $highlightEdit = null;
    protected $listeners = ['showOrderDetailsEvent'];

    public function showOrderDetailsEvent($id , $mainStatus)
    {
        $this->mainStatus = $mainStatus;
        $this->data = OrderDetails::where("order_id", $id)
            ->get();
        $this->resetProperties();

        $this->dispatch("showModelToggleXl");
    }


        //============All Methods For Delete Item From Order

    public function deleteItem($slug, $orderId ,$QTY ,$color , $size , $numIndex) 
    {
        $Key = $slug . '&' . $orderId;
        $this->highlightDelete = $numIndex;
        $this->close = true;

        if ($this->deleteKey === $Key) {
            $this->deleteKey = null;
        } else {
            $this->deleteKey = $Key;
            $this->secritKey = $Key;
        }

        $this->slug = $slug;
        $this->orderId = $orderId;
        $this->color = $color;
        $this->size = $size;
        $this->maxDeletedQTY = $QTY;

        return;
    }

    public function canceleDelete(){
        $this->resetProperties();
    }

    public function removeRules(){
        return [
            'reasonDelete' => 'required|string|min:3|max:500',
            'QTYDelete' => "required|integer|min:1|max:$this->maxDeletedQTY",
        ];
    }
    public function removeItem(){

        $this->validate($this->removeRules());
        $this->productDetails = OrderDetails::where('slug', $this->slug)
            ->where('color', $this->color)
            ->where('size', $this->size)
            ->where('order_id', $this->orderId)
            ->first();
            $statusCancelled = $this->QTYDelete == $this->productDetails->QTY ? 'cancelled' : 'partially_cancelled';
            
            if(isset($this->productDetails->modification_reason)){
            if($statusCancelled == 'partially_cancelled'){
                $status = 'modified_and_cancelled';
                $reasonEdit = $this->productDetails->modification_reason;
                $QTYEdit = $this->productDetails->QTY_edit;
                $statusModification = $this->productDetails->status_modification;
            }else{
                $status = 'cancelled';
                $reasonEdit = null ;
                $QTYEdit = 0 ;
                $statusModification = 'closed';
            }
        }elseif($statusCancelled == 'cancelled'){
            $status = 'cancelled';
            $reasonEdit = null;
            $QTYEdit = 0;
            $statusModification = 'closed';
        }else{
            $status = 'success';
            $reasonEdit = $this->productDetails->modification_reason;
            $QTYEdit = $this->productDetails->QTY_edit;
            $statusModification = $this->productDetails->status_modification;
        }

        $priceForPice = $this->productDetails->final_price/ $this->productDetails->QTY;
        $deletedPrice = $priceForPice * $this->QTYDelete;
        $fullQTYDelete = $this->productDetails->QTY_delete + $this->QTYDelete;
        $fullQTY = $this->productDetails->QTY - $this->QTYDelete;

        $this->productDetails->update([
            'status' => $status,
            'status_cancelled' => $statusCancelled ,
            'QTY_delete' =>  $fullQTYDelete,
            'cancel_reason' => $this->reasonDelete,
            'status_modification' => $statusModification ,
            'QTY_edit' => $QTYEdit ,
            'modification_reason' => $reasonEdit,
            'QTY' => $fullQTY,
            'final_price' =>  $this->productDetails->final_price - $deletedPrice,
        ]);

        $order = Order::where('id', $this->orderId)->first();
        if($this->productDetails->QTY  == 0){
            $i = 0 ;
            foreach($order->orderDetails as $itemData){
                if($itemData->QTY == 0){
                    $i++;
                }
            }
            if($i == $order->orderDetails->count()){

                $statusOrder = 'cancelled';
                $statusDetails = 'closed';
                $orderCanceleReason = 'you must be read more information for this order from details';
                
            }else{
                $statusOrder = 'accepted';
                $statusDetails = 'modified';
            }
        }else{
            $statusOrder = 'accepted';
            $statusDetails = 'modified';
        }

        $order->update([
            'status_details' => $statusDetails,
            'status_order' => $statusOrder,
            'cancel_reason' => $orderCanceleReason ?? null,
            'total' => $order->total - $deletedPrice,
            'finally_total' => $order->finally_total - $deletedPrice,
            'QTY' => $order->QTY - $this->QTYDelete,
        ]);


        $product = Product::findBySlug($this->slug);
        $product->update([
            'QTY' => $product->QTY + $this->QTYDelete,
            'sold' => $product->sold - $this->QTYDelete,
        ]);

        $product->productColorsSizes()
            ->whereHas('color', function ($q) {
                $q->where('name', $this->color);
            })
            ->whereHas('size', function ($q) {
                $q->where('name', $this->size);
            })
            ->increment('QTY', $this->QTYDelete);

        $this->dispatch('deletedItem');
        $this->dispatch("showModelToggleXl");
        if (auth()->guard('customerService')->check()) {
            $this->dispatch('dataRefresh')->to(DeliveryOrderComponent::class);
        } else {
            $this->dispatch('dataRefresh')->to(PickupOrderComponent::class);
        }
    }



    //============All Methods For Edit Item From Order
    public function editItem($itemId, $orderId , $slug, $numIndex)
    {
            $key = $itemId . '&' . $orderId;
            $this->key = $key;
            $this->highlightEdit = $numIndex;
            $this->close = true;
            $this->orderId = $orderId;

            $this->product = Product::findBySlug($slug);
            $this->productDetails = $this->product->getDetails();
            $this->itemEdited = OrderDetails::where('id', $itemId)
            ->where('order_id', $orderId)
            ->first();
    }

    public function canceleEdit()
    {
        $this->resetProperties();
    }

    public function editRules()
    {
        $maxQTYEdit = $this->productDetails[$this->selectedSize]['colors'][$this->selectedColor]['QTY'] ?? 0;
        return [
            'selectedSize' => 'required|integer|exists:product_color_sizes,size_id',
            'selectedColor' => 'required|integer|exists:product_color_sizes,color_id',
            'Qty' => "required|integer|min:1|max:$maxQTYEdit",
            'reasonEdit' => 'required|string|min:3|max:500',
        ];
    }
    public function saveChanges()
    {
        $this->validate($this->editRules());
        
        $relationPovit = $this->product->productColorsSizes()
        ->whereHas('color', function ($q) {
            $q->where('name', $this->productDetails[$this->selectedSize]['colors'][$this->selectedColor]['name']);
        })
        ->whereHas('size', function ($q) {
            $q->where('name', $this->productDetails[$this->selectedSize]['name']);
        })
        ->first();
        $selectedNameSize = $relationPovit->size->name;
        $selectedNameColor = $relationPovit->color->name;
        $name = $this->itemEdited->product_name;
        
        foreach ($this->data as $item) {
            if ($item->product_name == $name && $selectedNameColor == $item->color && $selectedNameSize == $item->size && $item->QTY == $this->Qty) {
                $this->dispatch("showModelToggleXl");
                $this->dispatch('errorFound');
                return;
            }
        }

        if($this->itemEdited->cancel_reason == 'partially_cancelled' ){
            $status = 'modified_and_cancelled';
        }
        
        $oldQty = $this->itemEdited->QTY;
        $priceForPice = $this->itemEdited->final_price / $oldQty;
        $oldTotalPrice = $priceForPice * $oldQty;
        $newTotalPrice= $priceForPice * $this->Qty;

        $this->itemEdited->update([
            'size' => $this->productDetails[$this->selectedSize]['name'],
            'color' => $this->productDetails[$this->selectedSize]['colors'][$this->selectedColor]['name'],
            'QTY' => $this->Qty,
            'final_price' => $newTotalPrice,
            'modification_reason' => $this->reasonEdit,
            'status_modification' => 'modified',
            'QTY_edit' => $this->itemEdited->QTY_edit + $oldQty,
            'status' => $status ?? 'success',
        ]);

        $order = Order::where('id', $this->orderId)->first();

        $order->update([
                'QTY' => $order->QTY - $oldQty + $this->Qty,
                'status_details' => 'modified',
                'total' => $order->total + $newTotalPrice - $oldTotalPrice,
                'finally_total' => $order->finally_total + $newTotalPrice - $oldTotalPrice,
            ]);

            $newQTYProdut = $this->product->QTY + $oldQty - $this->Qty;
            $newSoldProdut = $this->product->QTY - $oldQty + $this->Qty;

        $this->product->update([
            'QTY' => $newQTYProdut,
            'sold' => $newSoldProdut
        ]);


            $relationPovit->update([
                'QTY' => $relationPovit->QTY - $oldQty + $this->Qty,
            ]);
        $this->dispatch('editItem');
        $this->dispatch("showModelToggleXl");
        
        if(auth()->guard('customerService')->check()){
            $this->dispatch('dataRefresh')->to(DeliveryOrderComponent::class);
        }else{
            $this->dispatch('dataRefresh')->to(PickupOrderComponent::class);
        }
    }



    private function resetProperties()
    {
        $this->productDetails = null;
        $this->orderId = null;
        $this->slug = null;
        $this->close = false;

        $this->resetPropertiesEdit();
        $this->resetPropertiesDelete();

        $this->resetValidation();
    }


    private function resetPropertiesDelete()
    {
        $this->highlightDelete = -1;
        $this->secritKey = null;
        $this->deleteKey = '1';
        $this->maxDeletedQTY = 1;
        $this->reasonDelete = null;
        $this->QTYDelete = null;
        $this->color = null;
        $this->size = null;
    }


    private function resetPropertiesEdit()
    {
        $this->product = null;
        $this->highlightEdit = -1;
        $this->key = null;
        $this->itemEdited = null;
        $this->selectedColor = null;
        $this->selectedSize = null;
        $this->Qty = null;
        $this->reasonEdit = null;
    }
    
    public function render()
    {
        return view('livewire.order-management.pickup-order.show-order-details');
    }
}
