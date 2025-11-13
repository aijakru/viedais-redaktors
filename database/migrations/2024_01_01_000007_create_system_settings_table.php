<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, json, number
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('system_settings')->insert([
            [
                'key' => 'system_prompt',
                'value' => 'Esi pieredzējis teksta redaktors un analītiķis. Tava uzdevums ir analizēt tekstus un sniegt konstruktīvus ieteikumus to uzlabošanai. Vērtē tekstu pēc šādiem kritērijiem:

1. Lasāmība - cik viegli tekstu lasīt un saprast
2. Skaidrība - vai teksts ir skaidrs un saprotams
3. Teikumu garums - izvairīties no pārāk gariem teikumiem (vairāk par 25-30 vārdiem)
4. Struktūra - vai teksts ir labi strukturēts
5. Konkrētība - vai teksts satur konkrētu informāciju

Sniedz konkrētus, ieviešamus ieteikumus.',
                'type' => 'textarea',
                'description' => 'Galvenais sistēmas prompts AI analīzei',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'complex_sentence_threshold',
                'value' => '25',
                'type' => 'number',
                'description' => 'Vārdu skaits, pie kura teikums tiek uzskatīts par sarežģītu',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'readability_threshold_good',
                'value' => '60',
                'type' => 'number',
                'description' => 'Lasāmības indeksa slieksnis labam rezultātam',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'readability_threshold_warning',
                'value' => '40',
                'type' => 'number',
                'description' => 'Lasāmības indeksa slieksnis brīdinājumam',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};

