<?php

namespace App\Http\Requests\Report;

use App\Enums\ReportType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ReportRequest extends FormRequest
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
            'report_type' => [
                'required',
                new Enum(ReportType::class),
            ],
            'initial_date' => 'required|date',
            'final_date' => 'required|date',
        ];
    }
}
