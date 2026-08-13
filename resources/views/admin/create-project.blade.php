@extends('layout')

@section('title', 'إضافة مشروع جديد | لوحة التحكم')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <a href="{{ route('admin.index') }}" class="text-amber-500 hover:underline mb-6 inline-block">← العودة للوحة التحكم</a>
    
    <div class="bg-stone-900/30 border border-stone-800 p-8 rounded-sm">
        <h1 class="text-2xl font-bold mb-2 text-stone-100">إضافة عمل فني جديد للمعرض</h1>
        <p class="text-stone-400 text-sm mb-8">قم بتعبئة مواصفات الأمان والخامات ورفع الصورة الحقيقية للعمل بعد إنجازه في الورشة.</p>

        @if ($errors->any())
            <div class="bg-red-900/10 border border-red-900/30 text-red-500 p-4 rounded-sm mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- النموذج يدعم رفع الملفات عبر enctype="multipart/form-data" -->
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-stone-400 mb-2">عنوان العمل الفني / المشروع</label>
                    <input type="text" name="title" required value="{{ old('title') }}" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder="مثال: باب مصفح كلاسيكي بنقوش أندلسية">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-stone-400 mb-2">التصنيف</label>
                    <select name="category" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-400 text-sm rounded-sm">
                        <option value="الأبواب المدرعة">الأبواب المدرعة</option>
                        <option value="البوابات والأسوار">البوابات والأسوار</option>
                        <option value="درابزين سلالم">درابزين سلالم</option>
                        <option value="قطع أثاث وديكورات مخصصة">قطع أثاث وديكورات مخصصة</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-400 mb-2">الوصف التفصيلي للعمل</label>
                <textarea name="description" rows="4" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm resize-none" placeholder="اشرح تفاصيل التصنيع، ومستوى الأمان، والميزات المبتكرة..."></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-400 mb-2">الخامات والمواد المستخدمة (افصل بينها بفاصلة)</label>
                <input type="text" name="materials" required value="{{ old('materials') }}" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder="مثال: فولاذ صلب، خشب البلوط الطبيعي، قفل متعدد النقاط">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-stone-800/60 pt-6">
                <div>
                    <label class="block text-xs font-semibold text-stone-400 mb-2">سماكة الفولاذ (اختياري)</label>
                    <input type="text" name="steel_thickness" value="{{ old('steel_thickness') }}" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder="مثال: 3 ملم">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-stone-400 mb-2">معيار أو تصنيف الأمان (اختياري)</label>
                    <input type="text" name="security_rating" value="{{ old('security_rating') }}" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder="مثال: RC4">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-stone-400 mb-2">نوع الطلاء والتشطيب النهائي</label>
                    <input type="text" name="finish_type" required value="{{ old('finish_type') }}" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder="مثال: طلاء حراري مع لمسة برونزية">
                </div>
            </div>

            <div class="border-t border-stone-800/60 pt-6">
                <label class="block text-xs font-semibold text-stone-400 mb-2">تحميل صورة العمل الحقيقية</label>
                <input type="file" name="image" required class="w-full bg-stone-950 border border-stone-800 text-stone-400 p-3 text-sm rounded-sm focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-sm file:font-semibold file:bg-stone-800 file:text-amber-500 hover:file:bg-stone-700 cursor-pointer">
                <span class="text-[11px] text-stone-500 mt-2 block">الصيغ المقبولة: JPG, PNG, WEBP. الحجم الأقصى: 2 ميجابايت.</span>
            </div>

            <div class="text-left pt-4">
                <button type="submit" class="bg-amber-600 text-stone-950 px-8 py-3.5 font-semibold hover:bg-amber-700 transition text-sm">
                    حفظ ونشر المشروع بالمعرض البصري
                </button>
            </div>
        </form>
    </div>
</div>
@endsection