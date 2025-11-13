<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('custom_prompt')->nullable(); // Custom prompt for this category
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Insert default categories
        DB::table('categories')->insert([
            ['name' => 'Ziņa', 'slug' => 'news', 'description' => 'Īsa ziņa par notikumu', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Raksts', 'slug' => 'article', 'description' => 'Plašāks analītisks raksts', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Intervija', 'slug' => 'interview', 'description' => 'Saruna ar cilvēkiem', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Komentārs', 'slug' => 'commentary', 'description' => 'Viedokļa raksts', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sporta ziņas un raksti', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Politika', 'slug' => 'politics', 'description' => 'Politikas ziņas un analīze', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

