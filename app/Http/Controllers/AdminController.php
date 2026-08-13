<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // استيراد مكتبة التخزين لحذف الملفات ميكانيكياً

class AdminController extends Controller
{
    public function index()
    {
        $quotes = Quote::latest()->get();
        $projects = Project::latest()->get();
        return view('admin.index', compact('quotes', 'projects'));
    }

    public function createProject()
    {
        return view('admin.create-project');
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'materials' => 'required|string',
            'steel_thickness' => 'nullable|string|max:100',
            'security_rating' => 'nullable|string|max:100',
            'finish_type' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        $materialsArray = array_map('trim', explode(',', $request->materials));

        Project::create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'materials' => $materialsArray,
            'specs' => [
                'steelThickness' => $request->steel_thickness,
                'securityRating' => $request->security_rating,
                'finishType' => $request->finish_type,
            ],
            'images' => $imagePath ? [$imagePath] : [],
        ]);

        return redirect()->route('admin.index')->with('success', 'تم رفع وإضافة المشروع الجديد بنجاح.');
    }

    // 1. عرض صفحة تعديل المشروع
    public function editProject($id)
    {
        $project = Project::findOrFail($id);
        return view('admin.edit-project', compact('project'));
    }

    // 2. معالجة وتحديث بيانات المشروع والصورة
    public function updateProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'materials' => 'required|string',
            'steel_thickness' => 'nullable|string|max:100',
            'security_rating' => 'nullable|string|max:100',
            'finish_type' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // الصورة هنا اختيارية في التعديل
        ]);

        $imagePath = count($project->images) > 0 ? $project->images[0] : null;

        // إذا قام المستخدم برفع صورة جديدة، نحذف القديمة من الخادم لحفظ المساحة ونخزن الجديدة
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        $materialsArray = array_map('trim', explode(',', $request->materials));

        $project->update([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'materials' => $materialsArray,
            'specs' => [
                'steelThickness' => $request->steel_thickness,
                'securityRating' => $request->security_rating,
                'finishType' => $request->finish_type,
            ],
            'images' => $imagePath ? [$imagePath] : [],
        ]);

        return redirect()->route('admin.index')->with('success', 'تم تعديل وتحديث بيانات المشروع بنجاح.');
    }

    // 3. حذف المشروع نهائياً مع صورته المرفقة من القرص الصلب
    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);

        // حذف الصورة المادية من الخادم إن وجدت
        if (count($project->images) > 0) {
            Storage::disk('public')->delete($project->images[0]);
        }

        // حذف السجل من قاعدة البيانات
        $project->delete();

        return redirect()->route('admin.index')->with('success', 'تم حذف المشروع وصورته المرفقة بنجاح من النظام.');
    }
    // تحديث حالة طلب الاستشارة الخاص بالعميل
    public function updateQuoteStatus(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,contacted,completed',
        ]);

        $quote->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.index')->with('success', "تم تحديث حالة طلب العميل ({$quote->name}) بنجاح.");
    }
    // 1. عرض صفحة تعديل خطوة من خطوات العمل بالورشة
    public function editProcessStep($id)
    {
        $step = \App\Models\Process::findOrFail($id);
        return view('admin.edit-process-step', compact('step'));
    }

    // 2. تحديث نصوص الخطوة وحفظ الملف المرفوع وتحديد نوعه تلقائياً
    public function updateProcessStep(Request $request, $id)
    {
        $step = \App\Models\Process::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov,avi,webm|max:20480', // يدعم صور وفيديوهات لغاية 20 ميجابايت
        ]);

        $mediaPath = $step->media_path;
        $mediaType = $step->media_type;

        if ($request->hasFile('media')) {
            // إتلاف الملف القديم لتوفير مساحة التخزين بالخادم
            if ($mediaPath) {
                Storage::disk('public')->delete($mediaPath);
            }
            
            // تخزين الملف الجديد
            $mediaPath = $request->file('media')->store('process', 'public');
            
            // استخراج وتحديد نوع الملف برمجياً (صورة أم فيديو)
            $mimeType = $request->file('media')->getClientMimeType();
            $mediaType = str_contains($mimeType, 'video') ? 'video' : 'image';
        }

        $step->update([
            'title' => $request->title,
            'description' => $request->description,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
        ]);

        return redirect()->route('admin.index')->with('success', "تم تحديث الخطوة ({$step->step_number}) ورفع وسائطها بنجاح.");
    }
}