<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use App\Models\Department;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class UserController extends Controller
{
    public $user_info;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Your auth here
            $granted = false;
            $user = auth()->user();
            $granted = userAccess('USER');
            if ($granted) {
                return $next($request);
            }
            abort(403);
        });
    }


    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->has('v')) {
            return view('main-side.user');
        }
        //return view('user.company-table');
        return view('user.user-table');
    }

    /**
     * listDepartment
     *
     *
     * @return void
     */
    public function listDepartment()
    {
        return view('user.department');
    }



        /**
     * contact
     *
     *
     * @return void
     */
    public function contact()
    {
        return view('user.contact');
    }

        /**
     * duplicateContact
     *
     *
     * @return void
     */
    public function duplicateContact()
    {
        return view('user.manage-duplicate-contact');
    }

        /**
     * contact
     *
     *
     * @return void
     */
    public function contactEdit($id)
    {
        $contact = Contact::find($id);
        return view('user.contact-edit',['contact'=>$contact]);
    }
    /**
     * getDepartment
     *
     *
     * @return void
     */
    public function getDepartment(Request $request)
    {
        if(cache('viguard_id')){
            $userId = cache('viguard_id');
        }else{
            $userId = cache()->remember('viguard_id', 6000, function (){
                return Setting::where('key', 'viguard')->latest()->first()->value;
            });
        }
        $curl = curl_init();
        $code = $request->code;
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
            Log::debug($response);
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

        }
        // return response()->json([
        //     'msg' => "Successful sending to update depertment",
        //     'code' => 200
        // ]);

        return redirect('admin/department');
    }

    /**
     * show
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);

        // if ($request->has('v')) {
        //     return view('main-side.user-details', ['user' => $user, 'id' => $id]);
        // }
        if (count($user->super) > 0) {
            return view('user.user-profile', ['user' => $user]);
        }
        if ($user->name != 'Admin1') {
            return view('user.user-detail', ['user' => $user, 'id' => $id]);
        }
        return redirect('user');
    }


    /**
     * profile
     *
     * @param  mixed $user
     * @return void
     */
    public function profile(User $user)
    {
        if ($user->name != 'Admin') {
            return view('user.user-profile', ['user' => $user]);
        }
        return redirect('user');
    }

    /**
     * client
     *
     * @param  mixed $user
     * @return void
     */
    public function client(User $user)
    {

        return view('user.client-to-user', ['user' => $user]);
    }


    /**
     * clientUser
     *
     * @param  mixed $user
     * @param  mixed $client
     * @return void
     */
    public function clientUser(User $user, $client)
    {
        $clients = Client::find($client);
        return view('user.client-to-user-create', compact('user', 'clients'));
    }

    /**
     * client
     *
     * @param  mixed $user
     * @return void
     */
    public function request(User $user)
    {
        $currentMonth = now()->format('Y-m');
        $filterMonth = request()->input('filterMonth', $currentMonth);

        return view('user.user-request', ['user' => $user, 'filterMonth' => $filterMonth]);
    }

    /**
     * client
     *
     * @param  mixed $user
     * @return void
     */
    public function order(User $user)
    {

        return view('user.user-order', ['user' => $user]);
    }

    /**
     * provider
     *
     * @param  mixed $user
     * @return void
     */
    public function provider(User $user)
    {
        return view('user.user-provider', ['user' => $user]);
    }

    /**
     * balance
     *
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function balance($id, Request $request)
    {
        $user = User::find($id);

        return view('user.user-balance', ['user' => $user, 'id' => $id, 'team' => $request->has('team') ? $request->team : 0]);
    }

    /**
     * department
     *
     * @param  mixed $user
     * @return void
     */
    public function department(User $user)
    {
        if(cache('viguard_id')){
            $userId = cache('viguard_id');
        }else{
            $userId = cache()->remember('viguard_id', 6000, function (){
                return Setting::where('key', 'viguard')->latest()->first()->value;
            });
        }

        return view('user.user-depart', ['user' => $user, 'viguard'=>$userId]);
    }

    /**
     * departmentClient
     *
     * @param  mixed $user
     * @param  mixed $dept
     * @return void
     */
    public function departmentClient(User $user, Department $dept)
    {
        if(cache('viguard_id')){
            $userId = cache('viguard_id');
        }else{
            $userId = cache()->remember('viguard_id', 6000, function (){
                return Setting::where('key', 'viguard')->latest()->first()->value;
            });
        }
        return view('user.user-depart-client', ['viguard'=>$userId, 'user' => $user, 'department' => $dept]);
    }
}
