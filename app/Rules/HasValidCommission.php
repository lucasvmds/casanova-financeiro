<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class HasValidCommission implements InvokableRule, DataAwareRule
{
    protected $data = [];

    public function setData($data)
    {
        $this->data = $data;
    }

    private function relatedCommissionExists(int $product_id): bool
    {
        return array_key_exists(
            $product_id,
            $this->data['commissions'],
        );
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (! $this->relatedCommissionExists($value)) $fail('A comissão do campo :attribute é obrigatória');
    }
}
