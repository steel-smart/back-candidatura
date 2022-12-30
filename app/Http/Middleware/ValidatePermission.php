<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidatePermission
{
    public function handle(Request $request, Closure $next, $permissionName = null)
    {
        
            // return response()->json(['status' => 'unauthorized'], 401);
        
        return $next($request);
    }
}
