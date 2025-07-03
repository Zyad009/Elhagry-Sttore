<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
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

            'type_size' => 'required|in:letter,number',
            'name' => [
                'required',
                'unique:sizes,name',
                Rule::when($this->type_size === 'number', ['numeric', 'min:1', 'max:100']),
                Rule::when($this->type_size === 'letter', ['string', 'regex:/^[A-Za-z]+$/']),
            ],
        ];
    }
}
