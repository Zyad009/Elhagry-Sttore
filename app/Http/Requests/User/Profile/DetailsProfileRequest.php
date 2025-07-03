<?php

namespace App\Http\Requests\User\Profile;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class DetailsProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rulesPassword = [] ;
        $rulesCurrentPassword = [] ;
        if($this->input('password') || $this->input('current_password')){
                $rulesPassword = 'required|string|min:6|max:255|confirmed';
                $rulesCurrentPassword = 'required|string|min:6|max:255';
        }
        return [
            "phone" => [
                "required",
                "string",
                "regex:/^\+?[0-9\s\-\(\)]{10,20}$/",
                Rule::unique('users', "phone")->ignore($this->user()->id)
            ],
    
            "whatsapp" => [
                "required",
                "string",
                "regex:/^\+?[0-9\s\-\(\)]{10,20}$/",
                Rule::unique('users', "whatsapp")->ignore($this->user()->id)
            ],
    
            "email" => [
                "required",
                "email",
                "max:255",
                Rule::unique('users', "email")->ignore($this->user()->id)
            ],

            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'current_password' => $rulesCurrentPassword ,
            'password' => $rulesPassword ,
            "main_image" => "nullable|image|mimes:png,jpg,jpeg,gif|max:2048",
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled(['password', 'current_password'])) {
                if (!Hash::check($this->input('current_password'), $this->user()->password)) {
                    $validator->errors()->add('current_password', 'The current password is incorrect.');
                }
            }
        });
    }
}