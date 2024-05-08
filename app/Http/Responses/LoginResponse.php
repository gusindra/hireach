<?php

namespace App\Http\Responses;

use App\Models\RoleUser;
use App\Models\TeamUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        // replace this with your own code
        // the user can be located with Auth facade

        $home = Auth::user()->is_admin ? config('fortify.dashboard') : config('fortify.home');

        $teamuser = TeamUser::where('team_id', empty(auth()->user()->currentTeam) ? 1 : auth()->user()->currentTeam->id)->where('user_id', auth()->user()->id)->first();

        if ($teamuser) {
            $teamuser->update([
                'status' => 'Online'
            ]);

            if (auth()->user()->role && auth()->user()->currentTeam) {
                $role = RoleUser::where('user_id', auth()->user()->id)->where('team_id', auth()->user()->currentTeam->id)->first();
                if ($role) {
                    $role->update([
                        'active' => 1
                    ]);
                }
            }
        }


        $user = Auth::user();

        if ($user) {
            $isAdmin = RoleUser::where('user_id', $user->id)->where('role_id', 1)->exists();
            if ($isAdmin) {
                return redirect('/admin');
            } else {
                return redirect('/dashboard');
            }
        }

        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect($home);
    }
}
