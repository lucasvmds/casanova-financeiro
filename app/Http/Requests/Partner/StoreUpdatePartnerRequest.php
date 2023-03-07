<?php

namespace App\Http\Requests\Partner;

use App\Rules\HasValidCommission;
use App\Rules\IsValidCommission;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePartnerRequest extends FormRequest
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
            'name' => 'required|string',
            'products' => 'nullable|array',
            'products.*' => [
                'required',
                'numeric',
                new HasValidCommission,
            ],
            'commissions.*' => [ new IsValidCommission ],
        ];
    }
}
