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
 // app/Http/Middleware/CheckRole.php (المنطق الصحيح)

public function handle(Request $request, Closure $next, ...$roles): Response
{
    // الخطوة 1: التأكد أن هناك مستخدم مسجل الدخول
    if (!$request->user()) {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    // الخطوة 2: المرور على كل دور مطلوب للمسار (مثلاً 'teacher', 'guide')
    foreach ($roles as $role) {
        // الخطوة 3: هل المستخدم الحالي لديه هذا الدور المحدد؟
        // (نعتبر أن method hasRole() موجودة في User model وتعمل بشكل صحيح)
        if ($request->user()->hasRole($role)) {
            // إذا وجدنا أي دور مطابق، نسمح بالدخول فوراً وننهي الفحص
            return $next($request); // تفضل بالدخول!
        }
    }

    // الخطوة 4: إذا انتهت حلقة المرور ولم يتم العثور على أي دور مطابق
    // (أي أن المستخدم لا يمتلك "teacher" ولا "guide")
    // عندها فقط نرفض الدخول
    return response()->json(['message' => 'Forbidden.'], 403); // آسف، ممنوع!
}
}


