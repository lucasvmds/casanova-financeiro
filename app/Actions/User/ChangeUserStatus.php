<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use App\Support\FlashMessages;

class ChangeUserStatus
{
    /**
     * Deleta/restaura o usuário informado
     * 
     * @param \App\Models\User $user
     * @param \App\Support\FlashMessages $message
     * @return void
     */
    public static function run(User $user): void
    {
        if ($user->trashed()) {
            $user->restore();
            FlashMessages::success('Usuário ativado com sucesso');
        } else {
            $user->delete();
            FlashMessages::success('Usuário desativado com sucesso');
        }
    }
}