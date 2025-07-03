<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomAuth\LoginRequest;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $email, $password;


    public function getRules()
    {
        return (new LoginRequest())->rules();
    }

    public function updatedEmail()
    {
        $this->validateOnly("email");
    }

    public function updatedPassword()
    {
        $this->validateOnly("password");
    }

    public function submit()
    {
        $data = $this->validate();

        Auth::guard('saleOfficer')->logout();
        Auth::guard('customerService')->logout();
        Auth::guard('web')->logout();

        if (Auth::guard('admin')->attempt($data)) {
            $user = Auth::guard('admin')->user();
            Auth::login($user);
            return to_route('admin-dashboard.home');
        } elseif (Auth::guard('customerService')->attempt($data)) {

            $user = Auth::guard('customerService')->user();
            Auth::login($user);
            return to_route('admin-dashboard.home');
        } elseif (Auth::guard('web')->attempt($data)) {

            $user = Auth::guard('web')->user();
            return to_route('home');
        } elseif (Auth::guard('saleOfficer')->attempt($data)) {

            $user = Auth::guard('saleOfficer')->user();
            Auth::login($user);
            return to_route('pickup_orders.index');
        } else {
            $this->reset();
            throw ValidationException::withMessages([
                'email_not_correct' => trans('auth.failed'),
            ]);
        }
        // if (!is_null($cart)) {
        //     session()->put('cart', $cart);
        // }
    }


    public function render()
    {
        return view('livewire.auth.login');
    }
}
