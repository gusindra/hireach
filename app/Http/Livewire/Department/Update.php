<?php

namespace App\Http\Livewire\Department;

use App\Models\Client;
use App\Models\Department;
use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

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

        if(cache('viguard_id')){
            $userId = cache('viguard_id');
        }else{
            $userId = cache()->remember('viguard_id', 6000, function (){
                return Setting::where('key', 'viguard')->latest()->first()->value;
            });
        }
        $curl = curl_init();
        $code = $this->server;
        $server = config('viguard.server.'.$code);

        if($server){
            $auth = 'Authorization: '.$server["auth"];
            curl_setopt_array($curl, array(
                CURLOPT_URL => $server['url'].'/getAllDeptList',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    $auth,
                    'User-Agent: Apifox/1.0.0 (https://hireach.firmapps.ai)'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // dd($response);
            // Log::debug($response);
            $resData = json_decode($response, true);
            if($resData && $resData['data']){
                foreach($resData['data'] as $r){
                    // return $r['deptId'];
                    if($r['parentId']=="230"){
                        Department::updateOrCreate(
                            [
                                'source_id' => $r['deptId'],
                                'user_id' => $userId,
                                'server' => $code
                            ],
                            [
                                'parent' => $r['parentId'],
                                'ancestors' => $r['ancestors'],
                                'name' => $r['deptName']
                            ]
                        );
                    }
                }
            }
            $this->emit('dept_updated');
        }else{
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
