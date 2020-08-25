<?php

namespace App\Policies;

use App\Models\MarkedItem;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MarkedItem  $markedItem
     * @return mixed
     */
    public function view(User $user, MarkedItem $markedItem)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MarkedItem  $markedItem
     * @return mixed
     */
    public function update(User $user, MarkedItem $markedItem)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MarkedItem  $markedItem
     * @return mixed
     */
    public function delete(User $user, MarkedItem $markedItem)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MarkedItem  $markedItem
     * @return mixed
     */
    public function restore(User $user, MarkedItem $markedItem)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MarkedItem  $markedItem
     * @return mixed
     */
    public function forceDelete(User $user, MarkedItem $markedItem)
    {
        return false;
    }

    /**
     * @param User $user
     * @param MarkedItem $markedItem
     * @return bool
     */
    public function addUser(User $user, MarkedItem $markedItem)
    {
        return false;
    }
}
