<?php

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
