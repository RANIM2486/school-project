<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
//use illuminate\Support\Facades
use Illuminate\Support\Facades\Log;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
  public function handle(Request $request, Closure $next, $roles)
{
    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // إضافة ديباغ
    Log::info('User role:', ['role' => $user->role]);

    $userRoles = array_map('trim', explode(',', strtolower($user->role)));
    $requiredRoles = array_map('trim', explode(',', strtolower($roles)));

    foreach ($requiredRoles as $role) {
        if (in_array($role, $userRoles)) {
            return $next($request);
        }
    }

    return response()->json(['message' => 'Forbidden'], 403);
}


}


