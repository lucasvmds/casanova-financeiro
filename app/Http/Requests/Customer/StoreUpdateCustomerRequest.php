<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string',
            'cpf' => 'required|numeric',
            'rg' => 'required|string',
            'birth_date' => 'required|date',
            'street' => 'required|string',
            'number' => 'required|string',
            'district' => 'required|string',
            'complement' => 'nullable|string',
            'cep' => 'required|numeric',
            'additional_info' => 'nullable|string',
            'contacts' => 'required|array',
            'contacts.*.id' => 'nullable|numeric',
            'contacts.*.name' => 'required|string',
            'contacts.*.phone' => 'required|numeric',
            'contacts.*.email' => 'nullable|email',
        ];
    }
}
