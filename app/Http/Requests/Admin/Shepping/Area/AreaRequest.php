<?php

namespace App\Http\Requests\Admin\Shepping\Area;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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

    public function prepareForValidation()
    {
        if ($this->has('city_id')) {
            try {
                $decrypted = decrypt($this->input('city_id'));
                $this->merge([
                    'city_id' => $decrypted
                ]);
            } catch (\Exception $e) {
                abort(403, 'Invalid city ID');
            }
        }
    }

    
    public function rules(): array
    {
        return [
            "name"=>"required|string|min:3|max:50",
            "city_id"=>"required|integer|exists:cities,id",
            "delivery_price_regular"=>"required|numeric|min:0",
            "delivery_price_super"=>"required|numeric|min:0",
        ];
    }
}
