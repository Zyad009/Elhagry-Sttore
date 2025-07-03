<?php

namespace App\Http\Requests\Admin\CustomerService;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerServiceRequest extends FormRequest
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
            "name"=>"required|string|min:3|max:50",
            "email" => [
                "required",
                "string",
                "email",
                Rule::unique("customer_services", "email")->ignore($this->route("customerService"))
            ],
            "address" => "required|string|min:15|max:255",

            "phone" => [
                "required",
                "string",
                "regex:/^\+?[0-9\s\-\(\)]{10,20}$/",
                Rule::unique("customer_services", "phone")->ignore($this->route("customerService"))
            ],

            "whatsapp" => [
                "required",
                "string",
                "regex:/^\+?[0-9\s\-\(\)]{10,20}$/",
                Rule::unique("customer_services", "whatsapp")->ignore($this->route("customerService"))
            ],
            "gender" => "required|string|in:male,female",
            "main_image" => "nullable|image|mimes:png,jpg,jpeg,gif|max:2048",

            "password"=>"required|string|confirmed|min:6|max:50",
        ];
    }
}
