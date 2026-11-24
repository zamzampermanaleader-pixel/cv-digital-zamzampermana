<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'role',
        'technologies',
        'image_path',
        'project_url',
        'repository_url',
        'start_date',
        'end_date',
        'is_featured',
        'sort_order',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'technologies' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_featured' => 'boolean',
            'is_visible' => 'boolean',
        ];
    }
}
