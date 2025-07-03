<?php

namespace App\Http\Controllers\CustomAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomAuth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view("front.pages.auth.login");
    }

    // public function store(LoginRequest $request)
    // {

    //     $data = $request->validated();
    //     if (Auth::guard('admin')->attempt($data)) {

    //         $user = Auth::guard('admin')->user();
    //         Auth::login($user);

    //         return to_route('admin-dashboard.home');
    //     }
    //     elseif (Auth::guard('web')->attempt($data)) {

    //         return redirect()->route('home');
    //     } else {
    //         return back()->withErrors(["email_not_correct" => "your email or password not valid !"]);
    //     }
    // }
}
