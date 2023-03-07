<?php

declare(strict_types=1);

namespace App\Actions\Session;

use App\Http\Requests\Session\StoreSessionRequest;
use Illuminate\Support\Facades\Auth;

class ValidateUserCredentials
{
    public static function run(StoreSessionRequest $request): bool
    {
        $data = $request->validated();
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        if (! Auth::attempt($credentials, $data['remember'])) {
            return false;
        }

        Auth::logoutOtherDevices($data['password']);
        $request->session()->regenerate();
        return true;
    }
}