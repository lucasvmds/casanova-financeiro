<?php

namespace App\Http\Requests\Proposal;

use App\Enums\MainStatus;
use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProposalRequest extends FormRequest
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

    private function selectedStatusIsApproved(): bool
    {
        return Status::find($this->input('status_id'))->main === MainStatus::APPROVED->value;
    }

    private function requiredIfStatusIsApproved(string $field): string
    {
        return ($this->selectedStatusIsApproved() && !$this->input($field)) ?
            'required' :
            'nullable';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'status_id' => 'required|exists:statuses,id',
            'required_amount' => 'required|numeric|min:0',
            'additional_info' => 'nullable|string',
            'status_note' => 'nullable|string',
            'partner_id' => [
                $this->requiredIfStatusIsApproved('partner_id'),
                'exists:partners,id',
            ],
            'contract_identifier' => [
                $this->requiredIfStatusIsApproved('contract_identifier'),
                'string',
            ],
        ];
    }
}
