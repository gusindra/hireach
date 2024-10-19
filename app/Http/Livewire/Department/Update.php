<?php

namespace App\Http\Livewire\Department;

use App\Models\Client;
use App\Models\Department;
use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Update extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $server;
    public $servers;
    public $data = [];
    public $showClients = false;
    public $is_modal = true;

    public function mount($model = null)
    {
        if ($model != null) {
            $this->showClients = true;
        }
        $this->servers = config('viguard.server');
    }

    /**
     * updatedTemplateId
     *
     * @param  mixed $value
     * @return void
     */
    public function update()
    {
        // $client = Client::where('name', 'like', '%' . $value . '%')->orWhere('phone', 'like', '%' . $value . '%')->orWhere('email', 'like', '%' . $value . '%')->limit(5)->get();
        // $this->data = $client;

        if (cache('viguard_id')) {
            $userId = cache('viguard_id');
        } else {
            $userId = cache()->remember('viguard_id', 6000, function () {
                $viguardSetting = Setting::where('key', 'viguard')->latest()->first();

                if (!$viguardSetting) {

                    if (!$viguardSetting) {
                        dd('Setting for viguard is not found. Please create a viguard setting.');

                    }
                }

                return $viguardSetting->value;
            });
        }


        $code = $this->server;
        $server = config('viguard.server.' . $code);

        if ($server) {
            $auth = $server["auth"];
            $response = Http::withHeaders([
                'Authorization' => $auth,
                'User-Agent' => 'Apifox/1.0.0 (https://hireach.firmapps.ai)',
            ])->get($server['url'] . '/getAllDeptList');

            if ($response->successful()) {
                $resData = $response->json();

                if ($resData && isset($resData['data'])) {
                    foreach ($resData['data'] as $r) {
                        if ($r['parentId'] == "230") {
                            Department::updateOrCreate(
                                [
                                    'source_id' => $r['deptId'],
                                    'user_id' => $userId,
                                    'server' => $code,
                                ],
                                [
                                    'parent' => $r['parentId'],
                                    'ancestors' => $r['ancestors'],
                                    'name' => $r['deptName'],
                                ]
                            );
                        }
                    }
                }
                $this->emit('dept_updated');
            } else {
                $this->emit('dept_fail');
            }
        } else {
            $this->emit('dept_fail');
        }

        $this->modalActionVisible = false;
        $this->emit('refreshLivewireDatatable');
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
        return view('livewire.department.update');
    }
}
