<?php

namespace App\Http\Livewire\Commercial\Quotation;

use App\Models\Client;
use App\Models\Quotation;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Add extends Component
{
    public $modalActionVisible = false;
    public $type;
    public $title;
    public $date;
    public $valid_day;
    public $model;
    public $source;
    public $model_id;
    public $users;
    public $source_id;

    public function mount()
    {
        $this->users = User::all();
    }

    public function rules()
    {
        return [
            'type' => 'required',
            'title' => 'required',
            'date' => 'required',
            'valid_day' => 'required',
        ];
    }

    public function create()
    {

        $this->validate();

        Quotation::create($this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function updatedModelId($value)
    {
        $this->source_id = $value;
    }
    public function modelData()
    {
        $data = [
            'type'          => $this->type,
            'title'          => $this->title,
            'valid_day'     => $this->valid_day,
            'date'          => $this->date,
            'user_id'       => Auth::user()->id,
        ];


        if ($this->source) {
            $data['model']      = 'USER';
            $data['model_id']   = $this->source;
        }

        return $data;
    }

    public function resetForm()
    {
        $this->model_id = null;
        $this->type = null;
        $this->title = null;
        $this->date = null;
        $this->valid_day = null;
    }

    /**
     * createShowModal
     *
     * @return void
     */
    public function actionShowModal()
    {
        $this->modalActionVisible = true;
    }

    public function render()
    {
        return view('livewire.commercial.quotation.add');
    }
}
