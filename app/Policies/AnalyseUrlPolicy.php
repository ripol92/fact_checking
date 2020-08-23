<?php


namespace App\Policies;


use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnalyseUrlPolicy {
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, $model)
    {
        return false;
    }

    public function delete(User $user, $model)
    {
        return false;
    }

    public function view(User $user, $model)
    {
        return true;
    }
}
