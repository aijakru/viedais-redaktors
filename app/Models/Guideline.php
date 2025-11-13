<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guideline extends Model
{
    protected $fillable = [
        'title',
        'filename',
        'file_path',
        'file_type',
        'file_size',
        'extracted_content',
        'language_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}

