<?php

namespace App\Http\Livewire\Table;

use App\Models\Template;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;

class TemplatesTable extends LivewireDatatable
{
    public $model = Template::class;
    public $resource = '';

    public function builder()
    {
        $template = Template::query();
        if($this->resource!=''){
            $template = $template->where('resource', $this->resource);
        }
        return $template->where('user_id', auth()->user()->currentTeam->user_id);
        // ->with('teams')
        //     ->whereHas('teams', function ($query) {
        //         $query->where([
        //             'teams.id' => auth()->user()->currentTeam->id
        //         ]);
        //     }); //->where('user_id', auth()->user()->currentTeam->user_id);
    }

    public function columns()
    {
        return [
    		NumberColumn::name('uuid')->label('ID')->sortBy('id')->callback('uuid', function ($value) {
                return view('datatables::link', [
                    'href' => "/template/" . $value,
                    'slot' => substr($value, 30)
                ]);
            })->unsortable(),
    		Column::name('name')->label('Name')->unsortable(),
    		Column::name('description')->label('Description')->unsortable(),
    		Column::callback(['type'], function ($type) {
                return view('template.label', ['type' => $type]);
            })->label('Type')->unsortable(),
            Column::callback(['resource'], function ($resource) {
                if($resource==2){
                    return '1Way';
                }
                return '2Way';
            })->label('Resource')->unsortable(),
    		BooleanColumn::name('is_enabled')->label('Active')->unsortable()
    	];
    }
}
