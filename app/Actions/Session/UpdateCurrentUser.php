<?php

declare(strict_types=1);

namespace App\Actions\Session;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateCurrentUser
{
    public static function run(User $user, array $data): void
    {
        if (!$data['password']) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        Auth::logoutOtherDevices($data['current_password']);
        $user->update($data);
        session()->regenerate();
    }
}