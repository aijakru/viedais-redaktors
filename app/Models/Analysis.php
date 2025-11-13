<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $fillable = [
        'text_id',
        'word_count',
        'sentence_count',
        'paragraph_count',
        'avg_words_per_sentence',
        'readability_score',
        'complex_sentences',
        'improvements',
        'redundancies',
        'summary',
        'full_analysis',
        'overall_score',
    ];

    protected $casts = [
        'complex_sentences' => 'array',
        'improvements' => 'array',
        'redundancies' => 'array',
        'avg_words_per_sentence' => 'float',
        'readability_score' => 'float',
    ];

    public function text()
    {
        return $this->belongsTo(Text::class);
    }
}

