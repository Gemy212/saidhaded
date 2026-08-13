@extends('layout')

@section('title', 'تسجيل الدخول | لوحة تحكم الورشة')

@section('content')
<div class="max-w-md mx-auto px-4 py-24">
    <div class="bg-stone-900 border border-stone-800 p-8 rounded-sm">
        <h1 class="text-2xl font-bold mb-2 text-stone-100 text-center">بوابة الإدارة للورشة</h1>
        <p class="text-stone-400 text-xs text-center mb-8">قم بتسجيل الدخول لمراجعة استشارات العملاء وإدارة المعرض البصري.</p>

        @if(session('error'))
            <div class="bg-red-900/10 border border-red-900/30 text-red-500 p-3 rounded-sm mb-6 text-xs text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-stone-400 mb-2">اسم المستخدم</label>
                <input type="text" name="username" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder="أدخل اسم المستخدم">
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-400 mb-2">كلمة المرور</label>
                <input type="password" name="password" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-amber-600 text-stone-950 py-3 font-semibold hover:bg-amber-700 transition text-sm">
                تسجيل الدخول للإدارة
            </button>
        </form>
    </div>
</div>
@endsection