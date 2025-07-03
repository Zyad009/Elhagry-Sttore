<?php


namespace App\Livewire\Admin\Layouts;

use App\Models\Admin;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Nav extends Component
{
    public $name , $position , $image , $defaultImage;

    protected $listeners = ["updatedNavImage"];

    public function mount()
    {
        if(auth()->guard("admin")->check()){
            $user = Auth::guard("admin")->user();
            $this->image = $user->images->first()?->main_image;
            $this->name = $user->name;
            $this->position = $user->role = "editor_admin" ? "Manager Branch" : "Owner";
        }elseif(auth()->guard('customerService')->check()){
            $user = Auth::guard("customerService")->user();
            $this->image = $user->images->first()?->main_image;
            $this->name = $user->name;
            $this->position = "Customer Service";
        }else{
            $user = Auth::guard("saleOfficer")->user();
            $this->image = $user->images->first()?->main_image;
            $this->name = $user->name;
            $this->position = "Sale Officer";
        }
        
        if(!$this->image && $user->gender == "male"){
            $this->defaultImage = config("default-image.male-image");
        }else{
            $this->defaultImage = config("default-image.female-image");
        }
        
    }
    
    public function updatedNavImage()
    {
        if (auth()->guard("admin")->check()) {
            $user = Auth::guard("admin")->user();
            $this->image = $user->images->first()?->main_image;
            $this->name = $user->name;
            $this->position = $user->role = "editor_admin" ? "Manager Branch" : "Owner";
        } elseif(auth()->guard("customerService")->check()) {
            $user = Auth::guard("customerService")->user();
            $this->image = $user->images->first()?->main_image;
            $this->name = $user->name;
            $this->position = "Customer Service";
        }else{
            $user = Auth::guard("saleOfficer")->user();
            $this->image = $user->images->first()?->main_image;
            $this->name = $user->name;
            $this->position = "Sale Officer";
        }
        if (!$this->image && $user->gender == "male") {
            $this->defaultImage = config("default-image.male-image");
        } else {
            $this->defaultImage = config("default-image.female-image");
        }
    }

    public function render()
    {
        return view('livewire.admin.layouts.nav');
    }
}
