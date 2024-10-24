<?php

namespace App\Http\Livewire\Table;

use App\Models\BlastMessage;
use App\Models\Department;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;

class UserBlastMessageDepartementTable extends LivewireDatatable
{
    public $departmentId;

    public function builder()
    {

        $department = Department::find($this->departmentId);

        return BlastMessage::where('user_id', $department->user->id);
    }

    public function columns()
    {
        return [
            Column::name('title')->label('Message Title'),
            Column::name('message_content')->label('Content'),
            Column::name('status')->label('Status'),
            Column::name('created_at')->label('Sent At')->defaultSort('desc'),
        ];
    }
}
