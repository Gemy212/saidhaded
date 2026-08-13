@extends('layout')

@section('title', 'تحديث خطوة العمل | لوحة التحكم')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <a href="{{ route('admin.index') }}" class="text-amber-500 hover:underline mb-6 inline-block">← العودة للوحة التحكم</a>
    
    <div class="bg-stone-900/30 border border-stone-800 p-8 rounded-sm">
        <h1 class="text-2xl font-bold mb-2 text-stone-100">تحديث وسائط الخطوة #{{ $step->step_number }}: {{ $step->title }}</h1>
        <p class="text-stone-400 text-sm mb-8">قم بتعديل شرح الخطوة الحرفية أو رفع ملف وسيط (صورة للحدادين، أو مقطع فيديو يوضح الطرق الفني على الساخن) ليعرض للعميل.</p>

        @if ($errors->any())
            <div class="bg-red-900/10 border border-red-900/30 text-red-500 p-4 rounded-sm mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.process.update', $step->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-stone-400 mb-2">عنوان الخطوة الإنتاجية</label>
                <input type="text" name="title" required value="{{ old('title', $step->title) }}" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-400 mb-2">الشرح الهندسي والفني للخطوة</label>
                <textarea name="description" rows="5" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm resize-none">{{ old('description', $step->description) }}</textarea>
            </div>

            <!-- استعراض الوسائط الحالية إن وجدت -->
            @if($step->media_path)
                <div class="border-t border-stone-800/60 pt-6">
                    <label class="block text-xs font-semibold text-stone-400 mb-2">الوسيط المعروض حالياً للعملاء</label>
                    <div class="w-64 rounded-sm overflow-hidden border border-stone-800 bg-stone-950">
                        @if($step->media_type == 'video')
                            <video src="{{ asset('storage/' . $step->media_path) }}" controls class="w-full h-40 object-cover" muted></video>
                        @else
                            <img src="{{ asset('storage/' . $step->media_path) }}" class="w-full h-40 object-cover" alt="current media">
                        @endif
                    </div>
                </div>
            @endif

            <!-- حقل رفع وسيط بديل (صورة أو فيديو) -->
            <div class="border-t border-stone-800/60 pt-6">
                <label class="block text-xs font-semibold text-stone-400 mb-2">رفع ملف وسيط جديد (صورة أو مقطع فيديو)</label>
                <input type="file" name="media" class="w-full bg-stone-950 border border-stone-800 text-stone-400 p-3 text-sm rounded-sm focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-sm file:font-semibold file:bg-stone-800 file:text-amber-500 hover:file:bg-stone-700 cursor-pointer">
                <span class="text-[11px] text-stone-500 mt-2 block">الصيغ المقبولة: صور (JPG, PNG, WEBP)، فيديو (MP4, WEBM). الحجم الأقصى المتاح للملف: 20 ميجابايت.</span>
            </div>

            <div class="text-left pt-4">
                <button type="submit" class="bg-amber-600 text-stone-950 px-8 py-3.5 font-semibold hover:bg-amber-700 transition text-sm">
                    حفظ ونشر تحديثات الخطوة وعرضها للعملاء
                </button>
            </div>
        </form>
    </div>
</div>
@endsection