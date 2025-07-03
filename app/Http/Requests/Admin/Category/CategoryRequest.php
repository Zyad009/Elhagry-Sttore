<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        // $checkName = $this->isMethod("POST") ? "unique:categories,name" : "";
        return [
            "name" => ["required","string","min:3","max:30",
        Rule::unique("categories" , "name")->ignore(request()->route("category"))
        ],
            "main_image" => "nullable|image|mimes:png,jpg,jpeg,gif|max:2048",
        ];
    }
}
