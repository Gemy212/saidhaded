<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment("الحديد يطوع بالطرق والأفكار تبنى بالاستمرارية.");
})->purpose('عرض مقولة تحفيزية للورشة');
