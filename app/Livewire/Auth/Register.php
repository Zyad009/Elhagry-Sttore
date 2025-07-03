<?php

namespace App\Livewire\Auth;

use App\Mail\Auth\VerfiyAccountMail;
use App\Models\User;
use App\Models\OtpUser;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CustomAuth\RegisterRequest;

class Register extends Component
{
    public $first_name, $last_name, $email, $phone, $address, $gender , $whatsapp , $password , $password_confirmation;

    public function getRules()
    {
        return (new RegisterRequest())->rules();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit(){
        $user = $this->validate();
        $otp = rand(100000, 999999);
        $expireTime = now()->addMinutes(5);  
        $data = User::create($user  );
        OtpUser::create([
            "user_id" => $data->id,
            "otp" => $otp,
            "expires_at" => $expireTime ,
            "is_used" => false,
        ]);
        
        // Send OTP to the user via email 

        Mail::to($data->email)->send(new VerfiyAccountMail($otp , $data->email , $expireTime) );
        // Auth::guard("web")->login($data);
        return to_route('verify.email.index' , $data->email);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
