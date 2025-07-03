<?php

namespace App\Livewire\Admin\Offer\Product;

use App\Models\Offer;
use App\Models\Product;
use Livewire\Component;
use App\Http\Requests\Admin\Offer\OfferRequest;

class AddSpecialOffer extends Component
{

    public $data;
    public $discount_type , $discount , $start_date , $end_date;
    protected $listeners = ["createOffer"];
    
    public function mount(){
        $this->discount = '';
        $this->discount_type = '';
        $this->start_date = '';
        $this->end_date = '';
    }

    public function createOffer($id){
        $this->dispatch("showModelToggle");
        $this->data = Product::where("id", $id)->first();
    }

    public function rules()
    {
        return [
            'discount_type' => 'required|in:percentage,value',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'discount' => [
                'required',
                'numeric',
                'min:1',
                $this->discount_type === 'percentage' ? 'max:100' : '',
            ],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit(){
        $offer =  $this->validate();
        $createdOffer = Offer::create($offer);
        $offerId = $createdOffer->id;
        $this->data->update(["offer_id" => $offerId]);
        $this->dispatch("successOffer");
        $this->dispatch("refreshData")->to(AllProduct::class);
        $this->dispatch("showModelToggle");
    }
    public function render()
    {
        return view('livewire.admin.offer.product.add-special-offer');
    }
}
