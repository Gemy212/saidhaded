

<?php $__env->startSection('title', 'الرئيسية | ورشة الحدادة الفنية والمصنعات المدرعة'); ?>

<?php $__env->startSection('content'); ?>
    <div class="relative py-24 px-4 text-center bg-radial-[circle_at_center] from-stone-900 to-stone-950">
        <div class="max-w-3xl mx-auto">
            <span class="text-amber-500 uppercase tracking-widest text-sm font-semibold mb-4 block">أصالة الهندسة وقوة الحديد</span>
            <h1 class="text-4xl md:text-6xl font-bold mb-6 text-stone-100 leading-tight">الأبواب المدرعة والمصنوعات الفولاذية المخصصة</h1>
            <p class="text-stone-400 text-lg md:text-xl mb-10 max-w-xl mx-auto">أبواب مصفحة تحمي عائلتك وممتلكاتك، مصممة يدوياً وبمعايير هندسية صارمة تجمع بين عراقة الفن وأعلى درجات الأمان.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#quote" class="bg-amber-600 text-stone-950 px-6 py-3 font-medium hover:bg-amber-700 transition">طلب استشارة فنية مجانية</a>
                <a href="#portfolio" class="border border-stone-700 text-stone-300 px-6 py-3 font-medium hover:bg-stone-800/50 transition">استكشف معرض الأعمال</a>
            </div>
        </div>
    </div>

    <!-- معرض المشاريع الفنية المجلوبة من قاعدة البيانات -->
    <div id="portfolio" class="max-w-6xl mx-auto px-4 py-16 border-t border-stone-900">
    <h2 class="text-3xl font-bold mb-4 text-amber-500 border-r-4 border-amber-500 pr-3">معرض الأعمال المتميزة</h2>
    <p class="text-stone-400 text-sm mb-8">ابحث واكتشف الموديلات والقطع الفنية الحديدية المصممة في ورشتنا.</p>

    <!-- نموذج البحث والتصفية التفاعلي -->
    <form action="<?php echo e(route('home')); ?>#portfolio" method="GET" class="mb-10 space-y-6">
        <!-- الاحتفاظ بالفئة النشطة أثناء كتابة البحث -->
        <input type="hidden" name="category" value="<?php echo e($category ?? 'all'); ?>">

        <div class="flex flex-col md:flex-row gap-4 items-center">
            <!-- حقل البحث النصي -->
            <div class="relative w-full md:flex-grow">
                <input type="text" name="search" value="<?php echo e($search ?? ''); ?>" placeholder="ابحث عن تصميم... (مثال: كلاسيكي، مصفح، قصر، نحاسي)" class="w-full bg-stone-900 border border-stone-800 focus:border-amber-500 focus:outline-none p-3.5 pr-10 text-stone-200 text-sm rounded-sm">
                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-500 text-sm">🔍</span>
            </div>
            
            <div class="flex gap-3 w-full md:w-auto">
                <button type="submit" class="flex-grow md:flex-none bg-amber-600 text-stone-950 px-6 py-3.5 font-semibold hover:bg-amber-700 transition text-sm">
                    ابحث الآن
                </button>
                <?php if($search || ($category && $category !== 'all')): ?>
                    <a href="<?php echo e(route('home')); ?>#portfolio" class="border border-stone-800 text-stone-400 px-6 py-3.5 font-semibold hover:bg-stone-900 transition text-sm text-center flex items-center justify-center">
                        إعادة تعيين
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- أزرار التصنيفات التفاعلية كأوسمة (Tags) عصرية -->
        <div class="flex flex-wrap gap-2 pt-2">
            <?php
                $categories = [
                    'all' => 'الكل',
                    'الأبواب المدرعة' => 'الأبواب المدرعة المصفحة',
                    'البوابات والأسوار' => 'البوابات والأسوار الخارجية',
                    'درابزين سلالم' => 'درابزين سلالم وحماية',
                    'قطع أثاث وديكورات مخصصة' => 'أثاث وديكورات معدنية'
                ];
                $currentCategory = $category ?? 'all';
            ?>

            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- توليد رابط تفاعلي يحافظ على نص البحث الحالي -->
                <a href="<?php echo e(route('home', ['category' => $key, 'search' => $search])); ?>#portfolio" 
                   class="px-4 py-2 text-xs font-semibold rounded-full border transition duration-300 <?php echo e($currentCategory === $key ? 'bg-amber-600 text-stone-950 border-amber-600 font-bold' : 'border-stone-800 text-stone-400 hover:text-stone-200 hover:border-stone-700'); ?>">
                    <?php echo e($label); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </form>

    <!-- عرض المشاريع بعد التصفية والبحث -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-stone-900/50 border border-stone-800 p-6 flex flex-col justify-between hover:border-amber-600/30 transition duration-300">
                <div>
                    <!-- صورة المشروع مجهزة بعرض متناسب داخل الشبكة -->
                    <?php if($project->images && count($project->images) > 0): ?>
                        <?php
                            $imgUrl = str_contains($project->images[0], 'projects/') ? asset('storage/' . $project->images[0]) : asset($project->images[0]);
                        ?>
                        <img src="<?php echo e($imgUrl); ?>" alt="<?php echo e($project->title); ?>" class="w-full h-56 object-cover mb-4 rounded-sm border border-stone-800/80">
                    <?php else: ?>
                        <div class="w-full h-56 bg-stone-950 border border-stone-800 flex items-center justify-center mb-4 rounded-sm text-stone-600 text-xs">لا تتوفر صورة لهذا العمل حالياً</div>
                    <?php endif; ?>

                    <span class="text-xs text-amber-500 font-semibold uppercase"><?php echo e($project->category); ?></span>
                    <h3 class="text-xl font-bold my-2 text-stone-200"><?php echo e($project->title); ?></h3>
                    <p class="text-stone-400 text-sm mb-4 leading-relaxed line-clamp-3"><?php echo e($project->description); ?></p>
                </div>
                <div>
                    <a href="/projects/<?php echo e($project->id); ?>" class="text-amber-500 text-sm font-semibold hover:underline inline-block mt-4">عرض التفاصيل والمواصفات الفنية ←</a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-2 text-center text-stone-500 py-16 border border-stone-900 bg-stone-900/10">
                <p class="mb-2 text-stone-400">لا توجد أعمال تطابق خيارات البحث الحالية.</p>
                <p class="text-xs text-stone-600">جرب البحث بكلمات أخرى أو تغيير الفئة.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
    <!-- قسم نموذج طلب التسعير المخصص -->
    <div id="quote" class="max-w-4xl mx-auto px-4 py-16 border-t border-stone-900">
        <div class="bg-stone-900/30 border border-stone-800 p-8 rounded-sm">
            <h2 class="text-3xl font-bold mb-2 text-amber-500 text-center">استشارة وتخطيط مشروعك المخصص</h2>
            <p class="text-stone-400 text-center mb-8 text-sm">أدخل تفاصيل مقاسات الباب المدرع أو التصميم المطلوب، وسيتواصل معك كبير الحرفيين بالورشة قريباً.</p>

            <!-- عرض رسالة النجاح عند إرسال النموذج بنجاح -->
            <?php if(session('success')): ?>
                <div class="bg-amber-600/10 border border-amber-600/30 text-amber-500 p-4 rounded-sm mb-6 text-center text-sm font-medium">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('quote.store')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-stone-400 mb-2">الاسم بالكامل</label>
                        <input type="text" name="name" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder=" محمد هاني">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-stone-400 mb-2">رقم الجوال</label>
                        <input type="text" name="phone" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder="010xxxxxxxx">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-stone-400 mb-2">البريد الإلكتروني</label>
                        <input type="email" name="email" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder="name@example.com">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-stone-400 mb-2">نوع المشروع المطلوب</label>
                        <select name="project_type" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-400 text-sm rounded-sm">
                            <option value="">اختر نوع العمل...</option>
                            <option value="باب مدرع مصفح">باب مدرع مصفح</option>
                            <option value="بوابة قصر/فيلا خارجية">بوابة قصر/فيلا خارجية</option>
                            <option value="درابزين وحماية سلالم">درابزين وحماية سلالم</option>
                            <option value="قطع أثاث وتصاميم خاصة">قطع أثاث وتصاميم خاصة</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-stone-400 mb-2">المقاسات والأبعاد التقريبية (اختياري)</label>
                    <input type="text" name="dimensions" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm" placeholder="مثال: الارتفاع 220 سم، العرض 120 سم">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-stone-400 mb-2">تفاصيل إضافية وتفضيلات التصميم والأمان</label>
                    <textarea name="details" rows="4" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm resize-none" placeholder="اكتب هنا رغبتك بنوع الخشب، الميزات الأمنية المطلوبة، أو أي تفاصيل تخص التصميم..."></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="w-full sm:w-auto bg-amber-600 text-stone-950 px-8 py-4 font-semibold hover:bg-amber-700 transition text-sm">
                        إرسال مواصفات الطلب للورشة
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\TURKY\Desktop\metal_said\resources\views/home.blade.php ENDPATH**/ ?>