<?php

namespace App\Http\Livewire\Table;

use App\Models\Template; // Pastikan model Template diimpor
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;

class AssetTemplatesTable extends LivewireDatatable
{
    public function builder()
    {

        return Template::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('ID'),
            Column::name('name')->label('Template Name'),
            Column::name('created_at')->label('Created At'),
            Column::name('updated_at')->label('Updated At'),
        ];
    }
}
