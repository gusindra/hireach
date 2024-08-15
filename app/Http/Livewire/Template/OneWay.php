<?php

namespace App\Http\Livewire\Template;

use App\Models\Template;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class OneWay extends Component
{
    use AuthorizesRequests;
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
        $this->authorize('UPDATE_CONTENT_USR', $template->user_id);
        $template->update($this->modelData());

        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function edit($id)
    {
        $template = Template::findOrFail($id);
        $this->authorize('UPDATE_CONTENT_USR', $template->user_id);
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
        dd($template->user_id);
        $this->authorize('DELETE_CONTENT_USR', $template->user_id);
        $template->delete();

        $this->emit('refreshLivewireDatatable');
    }

    public function modelData()
    {
         return [
        'uuid' => Str::uuid(),
        'type' => strip_tags(filterInput($this->way == 2 ? $this->type : 'text')),
        'name' => strip_tags(filterInput($this->name)),
        'resource' => strip_tags(filterInput($this->way)),
        'description' => strip_tags(filterInput($this->description)),
        'user_id' => Auth::user()->id,
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
