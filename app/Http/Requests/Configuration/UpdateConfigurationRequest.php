<?php

namespace App\Http\Requests\Configuration;

use App\Enums\MainStatus;
use App\Rules\CanDeleteStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateConfigurationRequest extends FormRequest
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
            'seller_commission' => 'required|numeric|min:0|max:100',
            'statuses' => 'required|array',
            'statuses.*' => [
                'required',
                'array',
                new CanDeleteStatus,
            ],
            'statuses.*.id' => 'nullable|exists:statuses,id',
            'statuses.*.name' => 'required|string',
            'statuses.*.color' => 'required|string',
            'statuses.*.main' => [
                'required',
                new Enum(MainStatus::class),
            ],
            'statuses.*.active' => 'required|boolean',
        ];
    }
}
