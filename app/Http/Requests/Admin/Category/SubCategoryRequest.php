<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that    apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => [
                "required",
                "string",
                "min:3",
                "max:30",
                Rule::unique("categories", "name")->ignore($this->route("category"))
            ],
            "parent_id" => "required|exists:categories,id",
            "main_image" =>"nullable|image|mimes:png,jpg,jpeg,gif,|max:2048",
        ];
    }
}
