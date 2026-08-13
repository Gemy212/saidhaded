<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProjectSeeder::class,
            ProcessSeeder::class, // أضف هذا السطر هنا لتشغيله تلقائياً
        ]);
    }
}
