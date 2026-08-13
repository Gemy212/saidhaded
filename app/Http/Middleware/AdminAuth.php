<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // التحقق مما إذا كان المستخدم يملك جلسة تسجيل دخول نشطة
        if (!$request->session()->has('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'يجب تسجيل الدخول أولاً للوصول إلى لوحة التحكم.');
        }

        return $next($request);
    }
}