<?php

declare(strict_types=1);

namespace App\Actions\Common;

use App\Support\FlashMessages;
use Illuminate\Database\Eloquent\Model;

class DeleteOrRestoreModel
{
    public static function run(Model $model): void
    {
        if ($model->trashed()) {
            $model->restore();
            FlashMessages::success('Registro ativado com sucesso');
        } else {
            $model->delete();
            FlashMessages::success('Registro desativado com sucesso');
        }
    }
}