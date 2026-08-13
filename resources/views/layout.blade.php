<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ورشة الحدادة الفنية للأبواب المدرعة')</title>
    <!-- جلب Tailwind CSS لتوفير تصميم احترافي سريع وسلس -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-950 text-stone-100 min-h-screen flex flex-col font-sans">
    
    <!-- الهيدر وشريط التنقل -->
    <header class="border-b border-stone-900 bg-stone-950/80 backdrop-blur sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-amber-500 tracking-wider">الحدادة الفنية للأبواب المصفحة</a>
            <nav class="hidden md:flex gap-6 text-sm">
                <a href="/" class="hover:text-amber-500 transition">الرئيسية</a>
                <a href="/#portfolio" class="hover:text-amber-500 transition">معرض الأعمال</a>
                <a href="{{ route('process') }}" class="hover:text-amber-500 transition">مراحل العمل وعراقة الهوية</a>

            </nav>
            <a href="/#quote" class="bg-amber-600 text-stone-950 px-4 py-2 text-sm font-semibold hover:bg-amber-700 transition">طلب تسعير واستشارة</a>
        </div>
    </header>

    <!-- المحتوى المتغير -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- الفوتر -->
    <footer class="border-t border-stone-900 bg-stone-950 py-8 text-center text-stone-500 text-sm">
        <p>© 2026 ورشة الحدادة الفنية والأبواب المدرعة والمصفحة. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>
