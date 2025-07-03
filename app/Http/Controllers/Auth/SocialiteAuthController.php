<?php

namespace App\Http\Controllers\CustomAuth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteAuthController extends Controller
{
    public function redirect(string $driver)
    {
        if (!in_array($driver, ['google', 'facebook'])) {
            alert()->error('Invalid social driver!')->flash();
            return to_route('login.index');
        }

        return Socialite::driver($driver)->redirect();
    }

    public function callback(string $driver)
    {
        if (!in_array($driver, ['google', 'facebook'])) {
            abort(404);
        }
        try {
            $socialUser = Socialite::driver($driver)->stateless()->user();

            $fullName = $socialUser->getName();
            $nameParts = explode(' ', $fullName);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
            
        } catch (\Throwable $th) {
            alert()->error('Login failed!')->flash();
            return to_route('login.index');
        }
        $user = User::firstOrCreate([
            "email" => $socialUser->getEmail(),
        ], [
            "first_name" => $firstName,
            "last_name" => $lastName,
            "slug" => Str::slug($firstName . ' ' . $lastName),
            "password" => Hash::make(Str::random(16)),
            "phone" => null,
            "whatsapp" => null,
            "address" => null,
            "gender" => "male",
            "email_verified_at" => now(),
        ]);

        Auth::guard('web')->login($user, true);
        alert()->success('Login successful!')->flash();
        return to_route('home');
    }
}
