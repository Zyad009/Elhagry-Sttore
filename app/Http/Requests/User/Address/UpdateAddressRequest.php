<?php

namespace App\Http\Requests\User\Address;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'area_id' => 'required|exists:areas,id',
            'building' => 'required|string|max:255',
            'floor' => 'required|string|max:255',
            'apartment' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ];
    }
}
