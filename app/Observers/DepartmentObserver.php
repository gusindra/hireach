<?php

namespace App\Observers;

use App\Models\Department;
use App\Models\Notice;

class DepartmentObserver
{
    public function created(Department $dept)
    {
        Notice::create([
            'type' => 'admin',
            'model_id' => $dept->id,
            'model' => 'Department',
            'notification' => 'New Department ('.$dept->name.') from ViGuard is Created, please add contact to send Notification to Client',
            'user_id' => 1,
            'status' => 'unread',
        ]);
        addLog($dept, json_encode($dept->toArray()));
    }

    public function updated(Department $dept)
    {
        $before = $dept->getOriginal();
        addLog($dept, json_encode($dept->toArray()), json_encode($before));
        if($dept->client_id==0 || is_null($dept->client_id)){
            Notice::create([
                'type' => 'admin',
                'model_id' => $dept->id,
                'model' => 'Department',
                'notification' => 'Department ('.$dept->name.') contact is removed, please add contact to send Notification to Client',
                'user_id' => 1,
                'status' => 'unread',
            ]);
        }
    }
}
