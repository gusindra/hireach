<?php
namespace App\Http\Livewire\Table;

use App\Models\Provider;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProviderTable extends LivewireDatatable
{
    public $model = Provider::class;
    public $type;

    public function __construct($id = null, $type = null)
    {
        parent::__construct($id);
        $this->type = request()->query('type') ?? $type;
    }

    public function builder()
    {
        $query = Provider::query();
        if ($this->type) {
            $query->where('type', $this->type);
        }

        return $query;
    }

    public function columns()
    {
        return [
            Column::callback(['name', 'id'], function ($name, $id) {
                return view('datatables::link', [
                    'href' => "/admin/settings/providers/" . $id,
                    'slot' => strtoupper($name)
                ]);
            })->label('Name')->searchable(),
            Column::name('code')->label('Code'),
            Column::name('channel')->label('Channel'),
            Column::name('type')->label('Type'),
            Column::name('company')->label('Company'),
            BooleanColumn::name('status')->label('Status')
        ];
    }
}
