<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('texts', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('style')->nullable(); // ziņa, raksts, etc
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('texts');
    }
};

