<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('text_id')->constrained()->onDelete('cascade');
            
            // Metrics
            $table->integer('word_count');
            $table->integer('sentence_count');
            $table->integer('paragraph_count');
            $table->decimal('avg_words_per_sentence', 5, 2);
            $table->decimal('readability_score', 5, 2)->nullable();
            
            // AI Analysis Results
            $table->json('complex_sentences')->nullable(); // Array of complex sentences
            $table->json('improvements')->nullable(); // Array of improvement suggestions
            $table->json('redundancies')->nullable(); // Things to remove
            $table->text('summary')->nullable(); // Bullet-point summary
            $table->text('full_analysis')->nullable(); // Full AI analysis
            
            // Scoring
            $table->string('overall_score')->nullable(); // good, warning, danger
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};

