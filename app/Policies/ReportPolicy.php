<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class ReportPolicy
{
    use HandlesAuthorization;

    public function __construct(
        private Request $request,
    ){}

    public function index(User $user): bool
    {
        return $user->group === UserGroup::ADMIN->value;
    }

    public function url(User $user): bool
    {
        return $user->group === UserGroup::ADMIN->value;
    }

    public function generate(User $user): bool
    {
        return $user->group === UserGroup::ADMIN->value &&
            $this->request->hasValidSignature();
    }
}
