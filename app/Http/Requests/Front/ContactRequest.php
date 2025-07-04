<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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

        return [
            "name" => "required|string|min:3|max:50",
            "email" => "required|email",
            "subject" => "required|string|min:5|max:100",
            "message" => "required|min:10|max:500",
            "phone" => "required|string", 
        ];
    }
}
