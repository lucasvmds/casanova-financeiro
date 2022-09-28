<?php

namespace App\Rules;

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
            return ! Proposal::where('status_id', $value['id'])
                ->take(1)
                ->exists();
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
