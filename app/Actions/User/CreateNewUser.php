<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateNewUser
{
    public static function run(array $data): void
    {
        $data['password'] = Hash::make($data['password']);
        User::create($data);
    }
}