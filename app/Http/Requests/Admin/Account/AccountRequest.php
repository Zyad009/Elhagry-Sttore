<?php

namespace App\Http\Requests\Admin\Account;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=> 'required|string|max:255',
            'email'=> 'required|email|max:255|unique:users,email',
            'gender'=> 'required|in:male,female',
            'phone'=> 'required|digits_between:10,15|unique:users,phone',
            'whatsapp'=> 'required|digits_between:10,15',
            'address'=> 'required|string|max:500',
            'oldPassword'=> 'required|string|min:8',
            'password'=> 'required|string|min:8|confirmed',
            'password_confirmation'=> 'required|string|same:password',
        ];
    }
}
