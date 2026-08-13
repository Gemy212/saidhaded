<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    // استقبال مدخلات العميل وتمريرها للمستودع
    public function index(Request $request)
    {
        $category = $request->input('category', 'all');
        $search = $request->input('search');

        // جلب المشاريع المصفاة
        $projects = $this->projectRepo->searchAndFilter($category, $search);

        return view('home', compact('projects', 'category', 'search'));
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