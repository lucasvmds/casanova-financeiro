<?php

namespace App\Rules;

use App\Enums\MainStatus;
use App\Models\Proposal;
use Illuminate\Contracts\Validation\Rule;

class CanDeleteStatus implements Rule
{
    protected $status;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->status = $value;

        if (! $value['active']) {
            foreach (Proposal::where('status_id', $value['id'])->get() as $proposal) {
                if ($proposal->status()->first('main')->main === MainStatus::OPEN->value) return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O status '.$this->status['name'].' contém propostas vinculadas, não podendo ser desativado.';
    }
}
