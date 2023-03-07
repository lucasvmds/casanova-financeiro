<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Validator;

class IsValidCommission implements InvokableRule, DataAwareRule
{
    protected $data = [];

    public function setData($data)
    {
        $this->data = $data;
    }

    private function relatedProductExists(string $attribute): bool
    {
        $matches = [];
        preg_match('/commissions\.(\d+)/', $attribute, $matches);
        return array_key_exists(
            $matches[1] ?? '',
            $this->data['products'],
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
        if (! $this->relatedProductExists($attribute)) return;

        $validator = Validator::make(
            $this->data,
            [ $attribute => 'numeric|min:0|max:100', ],
        );

        if (count($error = $validator->errors())) {
            $fail(
                $error->first($attribute)
            );
        }
    }
}
