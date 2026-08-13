

<?php $__env->startSection('title', 'تعديل مشروع فني | لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-4 py-12">
    <a href="<?php echo e(route('admin.index')); ?>" class="text-amber-500 hover:underline mb-6 inline-block">← العودة للوحة التحكم</a>
    
    <div class="bg-stone-900/30 border border-stone-800 p-8 rounded-sm">
        <h1 class="text-2xl font-bold mb-2 text-stone-100">تعديل بيانات: <?php echo e($project->title); ?></h1>
        <p class="text-stone-400 text-sm mb-8">قم بتعديل المواصفات الأمنية أو رفع صورة جديدة لحل مكان الصورة الحالية.</p>

        <?php if($errors->any()): ?>
            <div class="bg-red-900/10 border border-red-900/30 text-red-500 p-4 rounded-sm mb-6 text-sm">
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.projects.update', $project->id)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-stone-400 mb-2">عنوان العمل الفني / المشروع</label>
                    <input type="text" name="title" required value="<?php echo e(old('title', $project->title)); ?>" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-stone-400 mb-2">التصنيف</label>
                    <select name="category" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-400 text-sm rounded-sm">
                        <option value="الأبواب المدرعة" <?php echo e($project->category == 'الأبواب المدرعة' ? 'selected' : ''); ?>>الأبواب المدرعة</option>
                        <option value="البوابات والأسوار" <?php echo e($project->category == 'البوابات والأسوار' ? 'selected' : ''); ?>>البوابات والأسوار</option>
                        <option value="درابزين سلالم" <?php echo e($project->category == 'درابزين سلالم' ? 'selected' : ''); ?>>درابزين سلالم</option>
                        <option value="قطع أثاث وديكورات مخصصة" <?php echo e($project->category == 'قطع أثاث وديكورات مخصصة' ? 'selected' : ''); ?>>قطع أثاث وديكورات مخصصة</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-400 mb-2">الوصف التفصيلي للعمل</label>
                <textarea name="description" rows="4" required class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm resize-none"><?php echo e(old('description', $project->description)); ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-400 mb-2">الخامات والمواد المستخدمة (مفصولة بفاصلة)</label>
                <input type="text" name="materials" required value="<?php echo e(old('materials', implode(', ', $project->materials))); ?>" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-stone-800/60 pt-6">
                <div>
                    <label class="block text-xs font-semibold text-stone-400 mb-2">سماكة الفولاذ (اختياري)</label>
                    <input type="text" name="steel_thickness" value="<?php echo e(old('steel_thickness', $project->specs['steelThickness'] ?? '')); ?>" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-stone-400 mb-2">معيار أو تصنيف الأمان (اختياري)</label>
                    <input type="text" name="security_rating" value="<?php echo e(old('security_rating', $project->specs['securityRating'] ?? '')); ?>" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-stone-400 mb-2">نوع الطلاء والتشطيب النهائي</label>
                    <input type="text" name="finish_type" required value="<?php echo e(old('finish_type', $project->specs['finishType'] ?? '')); ?>" class="w-full bg-stone-950 border border-stone-800 focus:border-amber-500 focus:outline-none p-3 text-stone-200 text-sm rounded-sm">
                </div>
            </div>

            <!-- عرض الصورة الحالية وخيار رفع الصورة البديلة -->
            <div class="border-t border-stone-800/60 pt-6">
                <label class="block text-xs font-semibold text-stone-400 mb-2">الصورة الحالية للعمل</label>
                <?php if(count($project->images) > 0): ?>
                    <?php
                        $imgUrl = str_contains($project->images[0], 'projects/') ? asset('storage/' . $project->images[0]) : asset($project->images[0]);
                    ?>
                    <img src="<?php echo e($imgUrl); ?>" class="w-32 h-32 object-cover rounded-sm border border-stone-800 mb-4" alt="الحالية">
                <?php endif; ?>
                
                <label class="block text-xs font-semibold text-stone-400 mb-2">رفع صورة بديلة (اتركها فارغة للاحتفاظ بالصورة الحالية)</label>
                <input type="file" name="image" class="w-full bg-stone-950 border border-stone-800 text-stone-400 p-3 text-sm rounded-sm focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-sm file:font-semibold file:bg-stone-800 file:text-amber-500 hover:file:bg-stone-700 cursor-pointer">
            </div>

            <div class="text-left pt-4">
                <button type="submit" class="bg-amber-600 text-stone-950 px-8 py-3.5 font-semibold hover:bg-amber-700 transition text-sm">
                    تحديث وحفظ التغييرات بالمعرض
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\TURKY\Desktop\metal_said\resources\views/admin/edit-project.blade.php ENDPATH**/ ?>