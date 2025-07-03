<?php

namespace App\Http\Controllers\CustomAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomAuth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index(){
        return view("auth.register");
    }

    public function create(RegisterRequest $request){

        $user = $request->validated();
        $data = User::create($user);
        Auth::guard("web")->login($data);

        return to_route('home');
    }
}
