<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\LogChange;
use Illuminate\Support\Facades\Auth;

class RoleObserver
{
    public function created(Role $role)
    {
        addLog($role, $role);
    }

    public function updated(Role $role)
    {

        $before = json_encode($role->getOriginal());

        $data = json_encode($role->toArray());

        addLog($role, $data, $before);
    }


    public function deleted(Role $role)
    {
        $data = json_encode($role->toArray());
        addLog($role, null, $data);
    }
}

