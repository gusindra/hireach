<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Models\DepartmentResource;
use Mediconesystems\LivewireDatatables\Column;

class DepartmentBlastMessageTable extends LivewireDatatable
{
    public $deptId;
    public function builder()
    {
        return DepartmentResource::query()->where('department_id',$this->deptId)->with(['blastMessage', 'request']);
    }

    public function columns()
    {
        return [
            Column::name('model')->label('Model'),
            Column::callback(['blastMessage.message_content', 'request.reply'], function ($messageContent, $reply) {
                // Combine with checks for empty values
                $parts = array_filter([$messageContent, $reply]);
                return implode(' ', $parts);
            })->label('Message'),
        ];
    }
}
