import os
from pathlib import Path

# 1. قائمة المجلدات الأساسية التي يحتاجها Laravel للعمل وتخزين الجلسات والملفات المؤقتة
DIRECTORIES = [
    "app/Http/Controllers",
    "app/Models",
    "app/Providers",
    "app/Repositories",
    "bootstrap",
    "config",
    "database/migrations",
    "database/seeders",
    "public",
    "resources/css",
    "resources/views",
    "routes",
    "storage/framework/cache/data",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/logs"
]

# 2. محتويات كافة الملفات اللازمة للمشروع بالكامل
FILES_CONTENT = {
    # ملفات التثبيت وإدارة الحزم
    "composer.json": """{
    "name": "laravel/laravel",
    "type": "project",
    "description": "The skeleton application for the Laravel framework.",
    "keywords": ["laravel", "framework"],
    "license": "MIT",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.0"
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.0",
        "phpunit/phpunit": "^10.5"
    },
    "autoload": {
        "psr-4": {
            "App\\\\": "app/",
            "Database\\\\Factories\\\\": "database/factories/",
            "Database\\\\Seeders\\\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\\\Foundation\\\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \\"file_exists('.env') || copy('.env.example', '.env');\\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi"
        ]
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
""",

    # أداة التحكم بالنظام عبر سطر الأوامر (artisan CLI)
    "artisan": """#!/usr/bin/env php
<?php

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/vendor/autoload.php';

$status = require_once __DIR__.'/bootstrap/app.php';

exit($status);
""",

    # بيئة التشغيل الأساسية في Laravel 11
    "bootstrap/app.php": """<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
""",

    # مزودو الخدمات المعتمدون في النظام
    "bootstrap/providers.php": """<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
];
""",

    # مزود الخدمة الافتراضي للارافل
    "app/Providers/AppServiceProvider.php": """<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
""",

    # مزود الخدمة المخصص لربط واجهات المستودعات (Repository Design Pattern)
    "app/Providers/RepositoryServiceProvider.php": """<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\ProjectRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
""",

    # ملف الاتصال بالخادم والواجهة العامة للموقع
    "public/index.php": """<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
""",

    # ملف إعدادات قاعدة البيانات والتطبيقات المحلي (.env)
    ".env": """APP_NAME="الحدادة الفنية"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blacksmith_db
DB_USERNAME=root
DB_PASSWORD=
""",

    # ملف ضبط قاعدة البيانات الاحتياطي
    "config/database.php": """<?php

return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'blacksmith_db'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
    ],
    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],
];
""",

    # مسارات الويب والتوجيه
    "routes/web.php": """<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProjectController::class, 'index'])->name('home');
Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
""",

    # مسار أوامر الكونسول الأساسي
    "routes/console.php": """<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(\"الحديد يطوع بالطرق والأفكار تبنى بالاستمرارية.\");
})->purpose('عرض مقولة تحفيزية للورشة');
""",

    # الموديل الأساسي للمشروع (Eloquent Model)
    "app/Models/Project.php": """<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'materials',
        'specs',
        'images',
        'client_testimonial'
    ];

    protected $casts = [
        'materials' => 'array',
        'specs' => 'array',
        'images' => 'array',
        'client_testimonial' => 'array',
    ];
}
""",

    # واجهة مستودع البيانات
    "app/Repositories/ProjectRepositoryInterface.php": """<?php

namespace App\Repositories;

interface ProjectRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function getByCategory($category);
}
""",

    # تنفيذ مستودع البيانات الفعلي
    "app/Repositories/ProjectRepository.php": """<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAll()
    {
        return Project::all();
    }

    public function getById($id)
    {
        return Project::find($id);
    }

    public function getByCategory($category)
    {
        return Project::where('category', $category)->get();
    }
}
""",

    # متحكم العرض الفني للمشاريع
    "app/Http/Controllers/ProjectController.php": """<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepositoryInterface;

class ProjectController extends Controller
{
    protected $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function index()
    {
        $projects = $this->projectRepo->getAll();
        return view('home', compact('projects'));
    }

    public function show($id)
    {
        $project = $this->projectRepo->getById($id);
        if (!$project) {
            abort(404, 'المنتج الفني المطلوب غير موجود.');
        }
        return view('project-details', compact('project'));
    }
}
""",

    # ملف هجرة الجداول لقاعدة بيانات MySQL
    "database/migrations/2026_01_01_000000_create_projects_table.php": """<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->text('description');
            $table->json('materials')->nullable();
            $table->json('specs')->nullable();
            $table->json('images')->nullable();
            $table->json('client_testimonial')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
""",

    # ملف بذر قاعدة البيانات التجريبي (Seeder)
    "database/seeders/ProjectSeeder.php": """<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'title' => 'باب فيلا رئيسي مصفح - طراز ملكي عتيق',
            'category' => 'الأبواب المدرعة',
            'description' => 'باب مدخل فيلا مدرع بهيكل فولاّذي مزدوج بسماكة 3 ملم، مع كسوة فاخرة من خشب الساج الطبيعي المعالج ضد العوامل الجوية ومزين بزخارف حديدية مطروقة يدوياً بالكامل في ورشتنا.',
            'materials' => ['فولاذ كربوني مقوى', 'خشب الساج الطبيعي', 'حديد مشغول يدوياً'],
            'specs' => [
                'steelThickness' => '3.0 ملم فائق الكثافة',
                'securityRating' => 'مطابق للمعيار الأوروبي RC4 لمقاومة الاقتحام والكسر الميكانيكي',
                'finishType' => 'طلاء بولي يوريثان حراري مع حماية ضد الأكسدة ولمسة نحاسية عتيقة'
            ],
            'images' => ['door1.jpg'],
            'client_testimonial' => [
                'clientName' => 'الأستاذ فيصل السديري',
                'feedback' => 'أعطى الباب واجهة هيبة للمنزل مع شعور لا يضاهى بالأمان والصلابة الحقيقية.'
            ]
        ]);

        Project::create([
            'title' => 'بوابة قصر مذهبة من الحديد المطاوع الكثيف',
            'category' => 'البوابات والأسوار',
            'description' => 'بوابة خارجية ضخمة مصنوعة يدوياً من قضبان الحديد المصمت المطروق على الساخن بنقوش كلاسيكية إيطالية، ومطعمة بورق الذهب المقاوم للأكسدة لتعكس أعلى مستويات الفخامة والأمان.',
            'materials' => ['حديد صلب ثقيل', 'ورق ذهب عيار 24 معالج', 'طلاء إيبوكسي بحري مقاوم للأملاح'],
            'specs' => [
                'steelThickness' => 'قضبان حديدية مصمتة بسماكة 16 ملم للمربعات الهيكلية',
                'securityRating' => 'مقاومة فائقة للاصطدامات الميكانيكية الشديدة',
                'finishType' => 'جلفنة حرارية كاملة قبل الطلاء لحماية تدوم لعقود دون تآكل'
            ],
            'images' => ['gate1.jpg'],
            'client_testimonial' => [
                'clientName' => 'المهندس عبدالرحمن الماجد',
                'feedback' => 'دقة التنفيذ وزخرفة الحديد مذهلة، البوابة تُعد قطعة فنية هندسية تليق بمدخل القصر.'
            ]
        ]);
    }
}
""",

    # المشغل الرئيسي لكافة عمليات البذر
    "database/seeders/DatabaseSeeder.php": """<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProjectSeeder::class,
        ]);
    }
}
""",

    # قوالب العرض (Blade Layout & Views)
    # قالب التصميم العام (layout.blade.php)
    "resources/views/layout.blade.php": """<!DOCTYPE html>
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
""",

    # الصفحة الرئيسية (home.blade.php)
    "resources/views/home.blade.php": """@extends('layout')

@section('title', 'الرئيسية | ورشة الحدادة الفنية والمصنعات المدرعة')

@section('content')
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
        <h2 class="text-3xl font-bold mb-8 text-amber-500 border-r-4 border-amber-500 pr-3">المشاريع والصناعات المنجزة</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($projects as $project)
                <div class="bg-stone-900/40 border border-stone-800 p-6 flex flex-col justify-between">
                    <div>
                        <span class="text-xs text-amber-500 font-semibold uppercase">{{ $project->category }}</span>
                        <h3 class="text-xl font-bold my-2 text-stone-200">{{ $project->title }}</h3>
                        <p class="text-stone-400 text-sm mb-4 leading-relaxed">{{ $project->description }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="/projects/{{ $project->id }}" class="text-amber-500 text-sm font-semibold hover:underline inline-block">عرض التفاصيل والمواصفات الفنية ←</a>
                    </div>
                </div>
            @empty
                <p class="col-span-2 text-center text-stone-500 py-12">لا توجد أعمال لعرضها حالياً. بانتظار تهيئة قاعدة البيانات وبذر البيانات الأولية.</p>
            @endforelse
        </div>
    </div>
@endsection
""",

    # صفحة تفاصيل المشروع الفردية (project-details.blade.php)
    "resources/views/project-details.blade.php": """@extends('layout')

@section('title', $project->title . ' | ورشة الحدادة الفنية')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-16">
        <a href="/" class="text-amber-500 hover:underline mb-8 inline-block">← العودة للرئيسية</a>
        
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
""",

    # ملف التنسيق الأساسي لـ CSS
    "resources/css/app.css": """@tailwind base;
@tailwind components;
@tailwind utilities;
"""
}

def build_infrastructure():
    print("================================================================")
    print("البدء في بناء البنية التحتية والمجلدات والملفات الكاملة لمشروع Laravel 11...")
    print("================================================================")
    
    # 1. إنشاء المجلدات أولاً لمنع حدوث أخطاء أثناء كتابة الملفات
    for directory in DIRECTORIES:
        path = Path(directory)
        path.mkdir(parents=True, exist_ok=True)
        print(f"[مجلد] تم التأسيس: {directory}")
        
    # 2. إنشاء وكتابة كافة الملفات البرمجية وهياكل التهيئة والمحاكاة
    for file_path, content in FILES_CONTENT.items():
        path = Path(file_path)
        path.parent.mkdir(parents=True, exist_ok=True)
        with open(path, "w", encoding="utf-8") as file:
            file.write(content)
        print(f"[ملف] تم التأسيس والكتابة: {file_path}")
        
    print("================================================================")
    print("انتهت عملية التأسيس بنجاح! جميع ملفات الهيكل الأساسي أصبحت جاهزة.")
    print("يرجى اتباع الخطوات الفنية التالية لتشغيل المشروع الفعلي على جهازك.")
    print("================================================================")

if __name__ == "__main__":
    build_infrastructure()