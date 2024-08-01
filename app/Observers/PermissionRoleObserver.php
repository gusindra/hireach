<?php

namespace App\Observers;

use App\Models\PermissionRole;

class PermissionRoleObserver
{
    public function created(PermissionRole $permissionRole)
    {
        dd(1);

        addLog($permissionRole, json_encode($permissionRole->toArray()));
    }

    public function updated(PermissionRole $permissionRole)
    {
        $before = $permissionRole->getOriginal();
        addLog($permissionRole, json_encode($permissionRole->toArray()), json_encode($before));
    }

    public function deleted(PermissionRole $permissionRole)
    {
        addLog($permissionRole, null, json_encode($permissionRole->toArray()));
    }
}
