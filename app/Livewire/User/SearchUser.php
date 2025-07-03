<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class SearchUser extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search;


    public function updatingSearch()
    {
        $this->resetPage();
    }   

    public function render()
    {
        return view('livewire.user.search-user', ["users" => User::with("images")
        ->where("phone", "LIKE", "%" . $this->search . "%")
        ->orWhere("first_name", "LIKE", "%" . $this->search . "%")
        ->orderBy("id", "desc")->paginate(config("pagination.count"))]);
    }
}
