<?php

namespace App\Http\Livewire\Contact;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Events\AddingTeam;

class Export extends Component
{
    public $modalActionVisible = false;
    public $input;
    public $inputclient;
    public $entity;
    public $model;
    public $source;
    public $showClients = false;
    public $is_modal = true;
    public $group_date = [];

    public function mount($model=null)
    {
        if($model!=null){
            $this->showClients = true;
        }
        // $this->group_date = Client::where('user_id', auth()->user()->id)->select(DB::raw('count(id) as `count`'), DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') as new_date"))
        // ->groupby('new_date')
        // ->get();;

        $this->group_date = Client::where('user_id', auth()->user()->id)->groupBy('created_at')->whereMonth('created_at', Carbon::now()->month)->get();
        //dd($this->group_date);
    }

    public function rules()
    {
        return [
            'input.title'       => 'required',
            'input.name'        => 'required',
            'input.email'       => 'required',
            'input.phone'       => 'required',
            'input.province'    => 'required',
            'input.city'        => 'required',
        ];
    }

    public function create()
    {
        //dd(1);
        $this->validate();
        $customer =  Client::create([
            'title'     => $this->input['title'],
            'name'      => $this->input['name'],
            'phone'     => $this->input['phone'],
            'email'     => $this->input['email'],
            'province'  => $this->input['province'],
            'city'      => $this->input['city'],
            'user_id'   => auth()->user()->id,
            'uuid'      => Str::uuid()
        ]);
        return redirect(request()->header('Referer'));

        //$this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function generatePassword()
    {
        $this->input['password'] = Str::random(8);
    }

    public function modelData()
    {
        $data = [
            'name' => $this->input['name'],
            'email' => $this->input['email'],
            'password' => Hash::make($this->input['password']),
        ];
        return $data;
    }

    public function resetForm()
    {
        $this->input = null;
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

    public function createFormUser()
    {
        dd(1);
    }

    public function render()
    {
        if($this->is_modal==false){
            return view('livewire.contact.form-add');
        }
        return view('livewire.contact.export');
    }
}
