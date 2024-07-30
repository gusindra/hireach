<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd($model);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user, $model, $modelId)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function view(User $user, $model, $modelId)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, $model)
    {
        $auth = Auth::user();
        if ($auth->super && $auth->super->isNotEmpty() && $auth->super->first()->role === 'superadmin') {
            return true;
        }
        if($user->activeRole){
            foreach ($user->activeRole->role->permission as $permission) {
                if (stripos($permission->name, strtoupper($model)) !== false) {
                    if (stripos($permission->name, "CREATE") !== false) {
                        return true;
                    }
                }
            }
        }else{
            if ($user->isNoAdmin && $user->isNoAdmin->role == "admin") {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User $user
     * @param  string $model
     * @return void
     */
    public function update(User $user, $model)
    {
        $auth = Auth::user();
        // return $user->id === $template->user_id;
        if ($auth->super && $auth->super->isNotEmpty() && $auth->super->first()->role === 'superadmin') {
            return true;
        }
        foreach ($user->activeRole->role->permission as $permission) {
            if ($permission->model == strtoupper($model)) {
                if (stripos($permission->name, "UPDATE") !== false) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function delete(User $user, $model)
    {

        $auth = Auth::user();
        if ($auth->super && $auth->super->isNotEmpty() && $auth->super->first()->role === 'superadmin') {
            return true;
        }
        $model = strtoupper($model);
        foreach ($user->activeRole->role->permission as $permission) {
            if (stripos($permission->name, $model) !== false && stripos($permission->name, 'DELETE') !== false) {
                return true;
            }
        }
        return false;
    }


    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function restore(User $user, $model, $modelId)
    {
        return true;

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function forceDelete(User $user, $model, $modelId)
    {
        return true;

    }
}
