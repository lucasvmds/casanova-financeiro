<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Enums\UserGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Enum;

class UpdateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(
                    (int) $this->route()->parameter('user')->id
                ),
            ],
            'group' => [ new Enum(UserGroup::class) ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(10)->letters()->numbers(),
            ],
        ];
    }
}
