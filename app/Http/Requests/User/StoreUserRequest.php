<?php

namespace App\Http\Requests\User;

use App\Enums\UserGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'group' => [ new Enum(UserGroup::class) ],
            'password' => [
                'required',
                'confirmed',
                Password::min(10)->letters()->numbers(),
            ],
        ];
    }
}
