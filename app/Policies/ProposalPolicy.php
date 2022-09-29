<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserGroup;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProposalPolicy
{
    use HandlesAuthorization;

    private function userIsManagerOrAdmin(User $user): bool
    {
        return $user->group === UserGroup::MANAGER->value || $user->group === UserGroup::ADMIN->value;
    }

    private function userIsProposalOwner(User $user, Proposal $proposal): bool
    {
        return $proposal->user_id === $user->id;
    }

    private function authorize(User $user, ?Proposal $proposal): bool
    {
        return $proposal instanceof Proposal ?
            ($this->userIsManagerOrAdmin($user) || $this->userIsProposalOwner($user, $proposal)) :
            $this->userIsManagerOrAdmin($user);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Proposal $proposal): bool
    {
        return $this->authorize($user, $proposal);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Proposal $proposal): bool
    {
        return $this->authorize($user, $proposal);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Proposal $proposal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Proposal $proposal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Proposal $proposal): bool
    {
        return false;
    }
}
