<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // تحقق من أن المستخدم مسجل دخول وله صلاحية admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // إذا لم يكن مدير، نرجعه للصفحة الرئيسية
        return redirect('/')->with('error', 'غير مصرح لك بالدخول لهذه الصفحة');
    }
}