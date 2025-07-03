<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        // $imageRule = $this->isMethod("POST") ? "required" : "nullable";
        return [
            "name" => "required|min:3|max:50",
            "price" => "required|numeric|min:0",
            "description" => "required|string|min:15|max:500",
            'type_size' => 'required|in:letter,number',
            "main_image" => "required|image|mimes:png,jpg,jpeg,gif|max:2048",
            "hover_image" => "required|image|mimes:png,jpg,jpeg,gif",
            "images" => "required|array|min:1|max:3",
            "images.*" => ["required", "file", "image", "mimes:png,jpg,jpeg,gif" , "max:2048"],
            "category_id" => "required|exists:categories,id",
        ];
    }
}
