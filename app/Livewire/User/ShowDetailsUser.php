<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class ShowDetailsUser extends Component
{
    public $user;
    protected $listeners = ['showDetailsUserEnent'];

    public function showDetailsUserEnent($id)
    {
        $this->user = User::find($id);
        $this->dispatch('showModelToggleXl');
    }
    public function render()
    {
        return view('livewire.user.show-details-user');
    }
}
