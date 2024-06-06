<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Vinkla\Hashids\Facades\Hashids;

class UserController extends Controller
{
    public $user_info;
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     // Your auth here
        //     $this->user_info=auth()->user()->super->first();
        //     if(($this->user_info && $this->user_info->role=='superadmin') || (auth()->user()->activeRole && str_contains(auth()->user()->activeRole->role->name, "Admin"))){
        //         return $next($request);
        //     }
        //     abort(404);
        // });
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

        return view('user.user-request', ['user' => $user,'filterMonth' => $filterMonth]);
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
}
