<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Route;

class UserPolicy
{
    use HandlesAuthorization;



    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, $model)
    {

        if ($user->isNoAdmin->role === "agen") {
            if (Route::currentRouteName() === 'message') {
                return true;
            }

            return false;
        }


        if ($model == $user->id || $model == auth()->user()->currentTeam->user->id) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  mixed  $menu
     * @return mixed
     */
    public function viewAny(User $user, $menu='')
    {
        if($menu=='message'){
            return true;
        }
        if ($user->isNoAdmin && $user->isNoAdmin->role == "admin") {
            return true;
        }

        return false;
    }







    /**
     * Determine whether the user can create users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {

        return true;

    }



    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, $model)
    {
        if ($model === $user->id || $model === auth()->user()->currentTeam->user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, $model)
    {
        if ($model === $user->id || $model === auth()->user()->currentTeam->user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function restore(User $user, $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
