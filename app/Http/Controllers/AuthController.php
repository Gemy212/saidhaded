<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // عرض صفحة تسجيل الدخول
    public function showLogin()
    {
        if (session()->has('admin_logged_in')) {
            return redirect()->route('admin.index');
        }
        return view('admin.login');
    }

    // التحقق من البيانات المدخلة ومقارنتها بالملف البيئي .env
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $envUsername = env('ADMIN_USERNAME', 'admin');
        $envPassword = env('ADMIN_PASSWORD', 'metal_said_secret');

        if ($request->username === $envUsername && $request->password === $envPassword) {
            // تخزين جلسة تسجيل دخول ناجحة
            $request->session()->put('admin_logged_in', true);
            return redirect()->route('admin.index');
        }

        return redirect()->back()->with('error', 'اسم المستخدم أو كلمة المرور غير صحيحة.');
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        return redirect()->route('home')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}