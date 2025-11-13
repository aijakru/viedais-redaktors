<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'custom_prompt', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function texts()
    {
        return $this->hasMany(Text::class);
    }

    public function knowledgeBase()
    {
        return $this->hasMany(KnowledgeBase::class);
    }
}

