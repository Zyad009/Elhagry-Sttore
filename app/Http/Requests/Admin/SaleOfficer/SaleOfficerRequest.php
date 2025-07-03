<?php

namespace App\Http\Requests\Admin\SaleOfficer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleOfficerRequest extends FormRequest
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
        $rule = $this->isMethod('POST') ? "required" : "nullable";
        return [
            "name" => "required|string|min:3|max:50",
            "email" => ["required","string","email",
                Rule::unique("sale_officers" , "email")->ignore($this->route("saleOfficer"))
        ],
            "address" => "required|string|min:15|max:255",


            "phone" => "required|string|unique:admins|regex:/^\+?[0-9\s\-\(\)]{10,20}$/",
            "whatsapp" => "required|string|unique:admins|regex:/^\+?[0-9\s\-\(\)]{10,20}$/",

            "gender" => "required|string|in:male,female",
            "main_image" => "nullable|image|mimes:png,jpg,jpeg,gif|max:2048",

            "pickup_point_id" => "required|exists:pickup_points,id",
            "password" => "$rule|string|confirmed|min:6|max:50",
        ];
    }
}
