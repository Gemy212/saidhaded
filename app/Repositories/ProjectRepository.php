<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAll()
    {
        return Project::latest()->get();
    }

    public function getById($id)
    {
        return Project::find($id);
    }

    public function getByCategory($category)
    {
        return Project::where('category', $category)->latest()->get();
    }

    // منطق البحث وتصفية المشاريع بشكل ديناميكي ومؤمن من ثغرات SQL Injection
    public function searchAndFilter($category = null, $searchTerm = null)
    {
        $query = Project::query();

        // التصفية بحسب فئة العمل الفني (أبواب مصفحة، بوابات...)
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        // البحث بكلمة مفتاحية في العنوان أو الوصف
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        return $query->latest()->get();
    }
}