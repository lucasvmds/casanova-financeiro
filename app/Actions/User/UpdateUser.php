<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;

class UpdateUser
{
    public static function run(array $data, User $user): void
    {
        if (! $data['password']) {
            unset($data['password']);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $user->update($data);
    }
}
