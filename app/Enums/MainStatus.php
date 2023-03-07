<?php

declare(strict_types=1);

namespace App\Enums;

enum MainStatus: string
{
    case OPEN = 'open';
    case APPROVED = 'approved';
    case CLOSED = 'closed';
}