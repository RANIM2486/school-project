<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
//use illuminate\Support\Facades

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$roles)
    {

      $user=$request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        foreach($roles as $role){
            if($user->role===$role)
         {
            return $next($request);
         }
            }
        return response()->json(['message' => 'Forbidden'], 403);
        }
     }


