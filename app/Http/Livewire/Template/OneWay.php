<?php

namespace App\Http\Livewire\Template;

use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class OneWay extends Component
{
    public $modalActionVisible = false;
    public $way = 1;
    public $type;
    public $name;
    public $description;
    public $selectedItemId;

    protected $rules = [
        'name' => 'required',
        'description' => 'required',
    ];

    public function create()
    {
        $this->validate();

        Template::create($this->modelData());

        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function update()
    {
        $this->validate();

        $template = Template::findOrFail($this->selectedItemId);
        $template->update($this->modelData());

        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function edit($id)
    {
        $template = Template::findOrFail($id);
        $this->selectedItemId = $id;
        $this->type = $template->type;
        $this->name = $template->name;
        $this->way = $template->resource;
        $this->description = $template->description;

        $this->modalActionVisible = true;
    }

    public function delete($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();

        $this->emit('refreshLivewireDatatable');
    }

    public function modelData()
    {
        return [
            'uuid'          => Str::uuid(),
            'type'          => $this->way == 2 ? $this->type : 'template',
            'name'          => $this->name,
            'resource'      => $this->way,
            'description'   => $this->description,
            'user_id'       => Auth::user()->id,
        ];
    }

    public function resetForm()
    {
        $this->type = null;
        $this->name = null;
        $this->way = 1; // Reset to default value
        $this->description = null;
        $this->selectedItemId = null;
    }

    public function actionShowModalOneWay()
    {
        $this->modalActionVisible = true;
    }

    public function render()
    {
        return view('livewire.template.one-way');
    }
}
