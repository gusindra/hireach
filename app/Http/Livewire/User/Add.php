<?php

namespace App\Http\Livewire\User;

use App\Models\BillingUser;
use App\Models\Client;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Events\AddingTeam;

class Add extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $input;
    public $inputclient;
    public $entity;
    public $model;
    public $role;
    public $source;

    public $roleId;
    public $showClients = false;
    public $is_modal = true;


    public $roles;

    public function mount($role, $model = null)
    {
        

        $roles = Role::all();

        if ($model != null) {
            $this->showClients = true;
        }

        $this->roles = $roles;
        $this->role = $role;
    }

    public function rules()
    {
        return [
            'input.name' => 'required',
            'input.password' => 'required',
        ];
    }

    /**
     * createUser
     *
     * @return void
     */
    public function createUser()
    {

        $this->validate();
        User::create($this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * create
     *
     * @return mixed
     */
    public function create()
    {


        $this->authorize('CREATE_USER', 'USER');
        $this->validate();

        $user = User::create($this->modelData());
        $team = Team::find(1);


        RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $this->roleId,
            'team_id' => $team->id,
        ]);

        $newTeamMember = Jetstream::findUserByEmailOrFail($user->email);
        $team->users()->attach(
            $newTeamMember,
            ['role' => 'editor']
        );
        AddingTeam::dispatch($user);
        $user->switchTeam($team = $user->ownedTeams()->create([
            'name' => $user->name,
            'slug' => slugify($user->name),
            'personal_team' => false,
        ]));

        if ($this->showClients) {
            $customer = Client::create([
                'title' => $this->inputclient['title'],
                'name' => $this->inputclient['name'],
                'phone' => $this->inputclient['phone'],
                'address' => $this->inputclient['address'],
                'note' => $this->inputclient['notes'],
                'email' => $user->email,
                'user_id' => 0,
                'uuid' => Str::uuid()
            ]);
            $team = Team::find(0);
            $customer->teams()->attach($team);
            if ($customer) {
                $billing = BillingUser::create([
                    'tax_id' => $this->inputclient['tax_id'],
                    'name' => $this->inputclient['name'],
                    'post_code' => $this->inputclient['postcode'],
                    'address' => $this->inputclient['address'],
                    'province' => $this->inputclient['province'],
                    'city' => $this->inputclient['city'],
                    'user_id' => $user->id
                ]);
            }
            return redirect(request()->header('Referer'));
        }

        $this->modalActionVisible = false;
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
            'roleId' => $this->roleId,
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
        $customer = Client::create([
            'title' => $this->inputclient['title'],
            'name' => $this->inputclient['name'],
            'phone' => $this->inputclient['phone'],
            'address' => $this->inputclient['address'],
            'note' => $this->inputclient['notes'],
            'email' => $this->inputclient['email'],
            'user_id' => auth()->user()->id,
            'uuid' => Str::uuid()
        ]);
        $team = Team::find(0);
        $customer->teams()->attach($team);
    }

    public function render()
    {
        if ($this->is_modal == false) {
            return view('livewire.user.form-add');
        }
        return view('livewire.user.add');
    }
}
