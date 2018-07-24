<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $roles = $request->user()->getRoles($user->id);
        if (in_array('mobile',$roles)) {
          return $next($request);
        }else{
          return abort(401, 'Unauthorized action.');
        }
    }
}
