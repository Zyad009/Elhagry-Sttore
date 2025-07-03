<?php

namespace App\Http\Requests\Admin\Editor;

use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditorRequest extends FormRequest
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
            "email" => [
                "required",
                "string",
                "email",
                Rule::unique("admins", "email")->ignore($this->route("editor"))
            ],
            "address" => "required|string|min:15|max:255",

            "phone" => ["required", "string", "regex:/^\+?[0-9\s\-\(\)]{10,20}$/",
            Rule::unique("admins", "phone")->ignore($this->route("editor"))],

            "whatsapp" => ["required", "string", "regex:/^\+?[0-9\s\-\(\)]{10,20}$/",
            Rule::unique("admins", "whatsapp")->ignore($this->route("editor"))],

            "gender" => "required|string|in:male,female",
            "main_image" => "nullable|image|mimes:png,jpg,jpeg,gif|max:2048",

            "password" => "required|string|min:6|confirmed",
        ];
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     alert()->error("Error!", "Data verification failed");

    //     throw new HttpResponseException(
    //         back()->withErrors($validator)->withInput()
    //     );
    // }
}
