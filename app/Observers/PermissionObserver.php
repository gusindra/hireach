<?php

namespace App\Observers;

use App\Models\Permission;
use App\Models\LogChange;

class PermissionObserver
{
    public function created(Permission $permission)
    {
        addLog($permission, json_encode($permission->toArray()));
    }

    public function updated(Permission $permission)
    {
        $before = json_encode($permission->getOriginal());
        $data = json_encode($permission->toArray());
        addLog($permission, $data, $before);
    }

    public function deleted(Permission $permission)
    {
        $data = json_encode($permission->toArray());
        addLog($permission, null, $data);
    }
}
