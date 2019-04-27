<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckFirstLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = Auth::user();
        if(Auth::guard($guard)->check() && $request->input('updated_at') == NULL){
            return redirect()->route('changePassword');
        }
        else{
            return $next($request);
        }    
    }
}
