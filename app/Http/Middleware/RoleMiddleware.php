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


        // تحقق مما إذا كان المستخدم مسجلاً الدخول
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // تحقق مما إذا كان للمستخدم الدور المطلوب
        if (Auth::user()->role !== $roles) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // إذا كان كل شيء على ما يرام، استمر في الطلب
        return $next($request);
    }
}

