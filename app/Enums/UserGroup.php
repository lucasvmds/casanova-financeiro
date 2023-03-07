<?php

declare(strict_types=1);

namespace App\Enums;

enum UserGroup: string
{
    case SELLER = 'seller';
    case MANAGER = 'manager';
    case ADMIN = 'admin';
}