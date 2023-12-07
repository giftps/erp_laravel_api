<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    */
    public function handle(Request $request, Closure $next, $role)
    {
        $exploded_roles = explode("|", $role);

        if (in_array(auth()->user()->role->name, $exploded_roles)){
            // if(auth()->user()->password_expiry_date){
            //     return response()->json(['error' => 'your login password is expired!', 401], 401);
            // }
            return $next($request);
        }else{
            return response()->json(['message' => 'You do not have permission to access this resource!'], 403);
        }
    }
}
