@extends('layout')

@section('title', $project->title . ' | ورشة الحدادة الفنية')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-16">
        <a href="/" class="text-amber-500 hover:underline mb-8 inline-block">← العودة للرئيسية</a>
        
        <!-- عرض الصورة الكاملة للمشروع -->
        @if($project->images && count($project->images) > 0)
            @php
                // التحقق الذكي من مسار الصورة سواء كانت مرفوعة حديثاً أو مضافة عبر البذر الافتراضي
                $imgUrl = str_contains($project->images[0], 'projects/') ? asset('storage/' . $project->images[0]) : asset($project->images[0]);
            @endphp
            <div class="mb-10 rounded-sm overflow-hidden border border-stone-800 bg-stone-900/20 p-2 flex justify-center">
                <!-- استخدام object-contain و h-auto يضمن عرض الصورة كاملة بجميع أبعادها دون أي قص من الأطراف -->
                <img src="{{ $imgUrl }}" alt="{{ $project->title }}" class="max-w-full h-auto max-h-[550px] object-contain rounded-sm">
            </div>
        @endif

        <span class="text-xs text-amber-500 font-semibold uppercase block mb-2">{{ $project->category }}</span>
        <h1 class="text-3xl md:text-5xl font-bold mb-6 text-stone-100">{{ $project->title }}</h1>
        
        <p class="text-stone-300 text-lg leading-relaxed mb-8">{{ $project->description }}</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-stone-900 pt-8 mb-8">
            <div>
                <h3 class="text-xl font-bold text-amber-500 mb-4">المواد والتركيب الخارجي</h3>
                <ul class="list-disc list-inside space-y-2 text-stone-400">
                    @foreach($project->materials as $material)
                        <li>{{ $material }}</li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold text-amber-500 mb-4">المواصفات الفنية والأمنية</h3>
                <ul class="space-y-3 text-stone-400">
                    @if(isset($project->specs['steelThickness']))
                        <li><strong>سمك الهيكل الداخلي:</strong> {{ $project->specs['steelThickness'] }}</li>
                    @endif
                    @if(isset($project->specs['securityRating']))
                        <li><strong>تصنيف ومعيار الأمان:</strong> {{ $project->specs['securityRating'] }}</li>
                    @endif
                    @if(isset($project->specs['finishType']))
                        <li><strong>الطلاء والمعالجة الحرارية:</strong> {{ $project->specs['finishType'] }}</li>
                    @endif
                </ul>
            </div>
        </div>

        @if($project->client_testimonial)
            <div class="bg-stone-900 border border-stone-800 p-6 rounded-sm mt-8">
                <p class="italic text-stone-300 mb-4">"{{ $project->client_testimonial['feedback'] }}"</p>
                <span class="text-amber-500 text-sm font-semibold">— {{ $project->client_testimonial['clientName'] }}</span>
            </div>
        @endif
    </div>
@endsection