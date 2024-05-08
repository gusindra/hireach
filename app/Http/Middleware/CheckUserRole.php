<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RoleUser;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $isAdmin = RoleUser::where('user_id', $user->id)->where('role_id', 1)->exists();
            if ($isAdmin) {
                return redirect('/admin');
            } else {
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
