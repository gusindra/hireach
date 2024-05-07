<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\RoleUser;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
  public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $this->userIsAdmin($user->id)) {
            return redirect('/admin');
        }
            return redirect('/dashboard');
   


    }

    private function userIsAdmin($userId)
    {
        return RoleUser::where('user_id', $userId)->where('role_id', 3)->exists();
    }
}
