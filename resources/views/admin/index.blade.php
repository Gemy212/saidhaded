@extends('layout')

@section('title', 'لوحة التحكم الإدارية | ورشة الحدادة الفنية')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="flex justify-between items-center mb-10 border-b border-stone-900 pb-6">
        <h1 class="text-3xl font-bold text-stone-100">لوحة تحكم الورشة</h1>
        <a href="{{ route('admin.projects.create') }}" class="bg-amber-600 text-stone-950 px-5 py-2.5 text-sm font-semibold hover:bg-amber-700 transition">
            + إضافة مشروع جديد للمعرض
        </a>
        <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="border border-stone-800 hover:bg-stone-900 text-stone-400 px-5 py-2.5 text-sm font-semibold transition">
                    تسجيل الخروج
                </button>
            </form>
    </div>

    @if(session('success'))
        <div class="bg-amber-600/10 border border-amber-600/30 text-amber-500 p-4 rounded-sm mb-8 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- القسم الأول: طلبات التسعير والاستشارات الواردة من العملاء -->
    <div class="mb-16">
        <h2 class="text-xl font-bold mb-6 text-amber-500">طلبات الاستشارات والتسعير المستلمة ({{ $quotes->count() }})</h2>
        <div class="overflow-x-auto bg-stone-900/40 border border-stone-800 rounded-sm">
            <table class="w-full text-right text-sm">
                <thead class="bg-stone-900 text-stone-400 border-b border-stone-800">
                    <tr>
                        <th class="p-4">العميل</th>
                        <th class="p-4">الاتصال</th>
                        <th class="p-4">نوع العمل</th>
                        <th class="p-4">المقاسات</th>
                        <th class="p-4">التفاصيل</th>
                        <th class="p-4">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-800/60">
                    @forelse($quotes as $quote)
                        <tr class="hover:bg-stone-900/30 transition">
                            <td class="p-4 font-semibold text-stone-200">
                                {{ $quote->name }}
                                <!-- عرض شارة ملونة ذكية حسب الحالة الحالية للطلب -->
                                <span class="block mt-1 text-[10px] px-2 py-0.5 rounded-full inline-block font-bold text-center
                                    @if($quote->status == 'new') bg-red-950 text-red-400 border border-red-900/40
                                    @elseif($quote->status == 'contacted') bg-yellow-950 text-yellow-400 border border-yellow-900/40
                                    @else bg-emerald-950 text-emerald-400 border border-emerald-900/40 @endif">
                                    @if($quote->status == 'new') جديد
                                    @elseif($quote->status == 'contacted') جاري المتابعة
                                    @else مكتمل @endif
                                </span>
                            </td>
                            <td class="p-4 text-stone-300">
                                <span class="block">{{ $quote->phone }}</span>
                                <span class="text-xs text-stone-500">{{ $quote->email }}</span>
                            </td>
                            <td class="p-4"><span class="bg-stone-800 text-amber-500 px-2 py-1 text-xs rounded-sm">{{ $quote->project_type }}</span></td>
                            <td class="p-4 text-stone-400 text-xs">{{ $quote->dimensions ?? 'غير محدد' }}</td>
                            <td class="p-4 text-stone-400 text-xs max-w-xs truncate" title="{{ $quote->details }}">{{ $quote->details ?? 'بدون تفاصيل إضافية' }}</td>
                            
                            <!-- نموذج تعديل حالة الطلب مدمج في الجدول بشكل مرن -->
                            <td class="p-4">
                                <form action="{{ route('admin.quotes.status', $quote->id) }}" method="POST" class="flex items-center gap-1.5">
                                    @csrf
                                    <select name="status" class="bg-stone-950 border border-stone-800 text-stone-300 text-xs p-1.5 rounded-sm focus:outline-none focus:border-amber-500">
                                        <option value="new" {{ $quote->status == 'new' ? 'selected' : '' }}>جديد</option>
                                        <option value="contacted" {{ $quote->status == 'contacted' ? 'selected' : '' }}>تم الاتصال</option>
                                        <option value="completed" {{ $quote->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    </select>
                                    <button type="submit" class="bg-stone-800 hover:bg-stone-700 text-amber-500 p-1.5 text-xs font-semibold rounded-sm transition" title="تحديث الحالة">
                                        ✓
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-stone-500">لا توجد طلبات استشارة واردة حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- القسم الثاني: المشاريع الحالية في المعرض مع خيارات CRUD -->
    <div class="mt-12">
        <h2 class="text-xl font-bold mb-6 text-stone-200 border-r-4 border-amber-500 pr-3">إدارة الأعمال والمعرض الميداني ({{ $projects->count() }})</h2>
        <div class="space-y-4">
            @foreach($projects as $p)
                <div class="bg-stone-900/40 border border-stone-800 p-4 rounded-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    
                    <!-- تفاصيل المشروع (الصورة والعنوان) -->
                    <div class="flex items-center gap-4">
                        @if($p->images && count($p->images) > 0)
                            @php
                                $imgUrl = str_contains($p->images[0], 'projects/') ? asset('storage/' . $p->images[0]) : asset($p->images[0]);
                            @endphp
                            <img src="{{ $imgUrl }}" class="w-12 h-12 object-cover rounded-sm border border-stone-800" alt="{{ $p->title }}">
                        @else
                            <div class="w-12 h-12 bg-stone-800 flex items-center justify-center text-xs text-stone-600 rounded-sm">بلا صورة</div>
                        @endif
                        <div>
                            <h3 class="font-bold text-stone-200 text-sm">{{ $p->title }}</h3>
                            <span class="text-xs text-amber-500 block mt-0.5">{{ $p->category }}</span>
                        </div>
                    </div>
                    
                    <!-- أزرار التحكم (التعديل والحذف) مصممة لتظهر بشكل ثابت ومباشر -->
                    <div class="flex items-center gap-3 mt-2 md:mt-0">
                        <a href="{{ route('admin.projects.edit', $p->id) }}" class="bg-amber-600 text-stone-950 hover:bg-amber-700 px-4 py-2 text-xs font-bold rounded-sm transition">
                            تعديل المواصفات
                        </a>
                        
                        <form action="{{ route('admin.projects.delete', $p->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المشروع وصورته نهائياً؟');" class="inline">
                            @csrf
                            <button type="submit" class="border border-red-900/60 text-red-500 hover:bg-red-950/20 px-4 py-2 text-xs font-bold rounded-sm transition">
                                حذف المشروع
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
    <!-- القسم الثالث الجديد: إدارة خطوات التصنيع والإنتاج بالورشة -->
    <div class="mt-16 border-t border-stone-900 pt-12">
        <h2 class="text-xl font-bold mb-6 text-amber-500 border-r-4 border-amber-500 pr-3">إدارة وتحديث وسائط خطوات التصنيع الفني (6 خطوات)</h2>
        <div class="overflow-x-auto bg-stone-900/40 border border-stone-800 rounded-sm">
            <table class="w-full text-right text-sm">
                <thead class="bg-stone-900 text-stone-400 border-b border-stone-800">
                    <tr>
                        <th class="p-4 w-20">الخطوة</th>
                        <th class="p-4">العنوان</th>
                        <th class="p-4">الوسائط المرفقة</th>
                        <th class="p-4 text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-800/60">
                    @php
                        // جلب الخطوات مباشرة وعرضها
                        $stepsList = \App\Models\Process::orderBy('step_number', 'asc')->get();
                    @endphp
                    @foreach($stepsList as $step)
                        <tr class="hover:bg-stone-900/30 transition">
                            <td class="p-4 font-bold text-amber-500 text-lg">#{{ $step->step_number }}</td>
                            <td class="p-4">
                                <span class="font-semibold text-stone-200 block">{{ $step->title }}</span>
                                <span class="text-stone-500 text-xs line-clamp-1 mt-1">{{ $step->description }}</span>
                            </td>
                            <td class="p-4">
                                @if($step->media_path)
                                    @if($step->media_type == 'video')
                                        <span class="text-xs bg-purple-950 text-purple-400 border border-purple-900/30 px-2.5 py-1 rounded-full font-bold">🎥 مقطع فيديو</span>
                                    @else
                                        <img src="{{ asset('storage/' . $step->media_path) }}" class="w-12 h-12 object-cover rounded-sm border border-stone-800" alt="media">
                                    @endif
                                @else
                                    <span class="text-xs text-stone-600">بلا وسائط (نص فقط)</span>
                                @endif
                            </td>
                            <td class="p-4 text-left">
                                <a href="{{ route('admin.process.edit', $step->id) }}" class="border border-amber-600/30 text-amber-500 hover:bg-amber-600/10 px-4 py-2 text-xs font-bold rounded-sm transition">
                                    تحديث وإضافة وسيط
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection