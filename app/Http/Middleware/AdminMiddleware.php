<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Middleware\Authenticate;
use Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
/** Auth::User()->roles()->first(); */

    {
        if (Auth::check()) {
            if(auth()->user()->hasRole("admin") == "admin"){
                return $next($request);
            } else {
                return redirect()->route('displayproducts');
            }
        } else {
            return redirect('/welcome');
        }
        return $next($request);
    }
}

