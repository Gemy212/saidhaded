@extends('layout')

@section('title', 'مراحل التصنيع وعراقة الهوية | ورشة الحدادة الفنية')

@section('content')
<!-- جزء التعريف بالهوية للورشة -->
<div class="relative py-20 bg-stone-900/20 border-b border-stone-900">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="text-amber-500 uppercase tracking-widest text-xs font-semibold mb-3 block">الصلابة في التصميم والأمان في البنيان</span>
        <h1 class="text-3xl md:text-5xl font-bold mb-6 text-stone-100">فلسفة التشكيل وعراقة الحدادة</h1>
        <p class="text-stone-400 text-md md:text-lg leading-relaxed max-w-2xl mx-auto">
            في ورشتنا، لا نتعامل مع الحديد كخامة صماء؛ بل نشكله بالطرق اليدوي على الساخن ليتوافق مع الرؤية المعمارية الفريدة لقصوركم وفيلاتكم، مدمجاً بأعلى تقنيات الحماية والدروع الفولاذية الداخلية لتأمين عائلاتكم وممتلكاتكم.
        </p>
    </div>
</div>

<!-- المخطط الزمني لمراحل التصنيع (Dynamic Visual Timeline) -->
<div class="max-w-4xl mx-auto px-4 py-20">
    <h2 class="text-2xl md:text-3xl font-bold mb-16 text-center text-amber-500">رحلة تصنيع الباب المدرع المخصص من الفكرة للتركيب</h2>
    
    <div class="relative border-r border-stone-800 mr-4 md:mr-12 space-y-20">
        
        <!-- حلقة تكرار جلب وعرض خطوات العمل الست والوسائط الخاصة بكل منها من قاعدة البيانات -->
        @foreach($steps as $step)
            <div class="relative pr-8 md:pr-12">
                <!-- أيقونة رقم الخطوة -->
                <span class="absolute right-[-13px] top-1 bg-amber-600 text-stone-950 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold ring-4 ring-stone-950">
                    {{ $step->step_number }}
                </span>
                
                <span class="text-xs text-amber-500 font-semibold uppercase tracking-wider">الخطوة #{{ $step->step_number }}</span>
                <h3 class="text-xl font-bold text-stone-200 mt-1 mb-3">{{ $step->title }}</h3>
                <p class="text-stone-400 text-sm leading-relaxed mb-6">{{ $step->description }}</p>

                <!-- عرض الوسائط (صور أو فيديوهات) المرفوعة خصيصاً لهذه الخطوة من لوحة التحكم -->
                @if($step->media_path)
                    <div class="max-w-2xl rounded-sm overflow-hidden border border-stone-800 bg-stone-950 p-1 mb-8">
                        @if($step->media_type == 'video')
                            <!-- مشغل فيديو HTML5 صامت ومكرر ليعمل كـ خلفية متحركة تفاعلية (Cinemagraph) -->
                            <video src="{{ asset('storage/' . $step->media_path) }}" 
                                   autoplay loop muted playsinline controls
                                   class="w-full h-auto max-h-[380px] object-cover rounded-sm">
                            </video>
                        @else
                            <!-- عرض صورة عالية الدقة للمرحلة -->
                            <img src="{{ asset('storage/' . $step->media_path) }}" 
                                 alt="{{ $step->title }}" 
                                 class="w-full h-auto max-h-[380px] object-cover rounded-sm">
                        @endif
                    </div>
                @endif
            </div>
        @endforeach

    </div>
</div>
@endsection