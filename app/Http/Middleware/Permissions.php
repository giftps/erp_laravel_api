<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Api\V1\UserAccess\Permission;
use App\Models\Api\V1\UserAccess\Module;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    
    public function handle(Request $request, Closure $next, $module)
    {
        $module_id = Module::where('name', '=', $module)->first()->module_id;
        $role_id = auth()->user()->role->role_id;

        return response()->json(['msg' => $role_id]);
        return $next($request);
    }
}
