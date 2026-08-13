<?php

namespace App\Repositories;

interface ProjectRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function getByCategory($category);
    
    // الميزة الجديدة للبحث والتصفية المدمجة
    public function searchAndFilter($category = null, $searchTerm = null);
}