<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 2)->unique(); // lv, ru, en
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Insert default languages
        DB::table('languages')->insert([
            ['code' => 'lv', 'name' => 'Latviešu', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'ru', 'name' => 'Русский', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'en', 'name' => 'English', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};

