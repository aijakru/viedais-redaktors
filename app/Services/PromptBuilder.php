<?php

namespace App\Services;

use App\Models\SystemSetting;
use App\Models\Guideline;
use App\Models\KnowledgeBase;
use App\Models\Category;

class PromptBuilder
{
    /**
     * Build complete prompt for text analysis
     */
    public function buildAnalysisPrompt(
        string $text, 
        int $languageId, 
        ?int $categoryId = null
    ): string {
        $prompt = "";
        
        // 1. System Instructions
        $prompt .= $this->getSystemInstructions();
        $prompt .= "\n\n";
        
        // 2. Language Context
        $prompt .= $this->getLanguageContext($languageId);
        $prompt .= "\n\n";
        
        // 3. Category-specific instructions
        if ($categoryId) {
            $categoryPrompt = $this->getCategoryPrompt($categoryId);
            if ($categoryPrompt) {
                $prompt .= $categoryPrompt;
                $prompt .= "\n\n";
            }
        }
        
        // 4. Editorial Guidelines
        $guidelines = $this->getGuidelines($languageId);
        if (!empty($guidelines)) {
            $prompt .= "REDAKCIONĀLĀS VADLĪNIJAS:\n";
            $prompt .= $guidelines;
            $prompt .= "\n\n";
        }
        
        // 5. Example Articles (Knowledge Base)
        $examples = $this->getExamples($languageId, $categoryId);
        if (!empty($examples)) {
            $prompt .= "PIEMĒRI LABIEM RAKSTIEM:\n";
            $prompt .= $examples;
            $prompt .= "\n\n";
        }
        
        // 6. Analysis Requirements
        $prompt .= $this->getAnalysisRequirements();
        $prompt .= "\n\n";
        
        // 7. The text to analyze
        $prompt .= "TEKSTS ANALĪZEI:\n";
        $prompt .= "```\n{$text}\n```\n\n";
        
        // 8. Output format
        $prompt .= $this->getOutputFormat();
        
        return $prompt;
    }

    /**
     * Get system instructions from settings
     */
    protected function getSystemInstructions(): string
    {
        $systemPrompt = SystemSetting::get('system_prompt');
        
        if (!$systemPrompt) {
            return 'Esi pieredzējis teksta redaktors. Analizē tekstu un sniedz konstruktīvus ieteikumus.';
        }
        
        return $systemPrompt;
    }

    /**
     * Get language-specific context
     */
    protected function getLanguageContext(int $languageId): string
    {
        $languages = [
            1 => 'Teksts ir latviešu valodā. Vērtē to pēc latviešu valodas normām un žurnālistikas standartiem.',
            2 => 'Текст на русском языке. Оценивай его по нормам русского языка и журналистским стандартам.',
            3 => 'The text is in English. Evaluate it according to English language norms and journalistic standards.',
        ];
        
        return $languages[$languageId] ?? $languages[1];
    }

    /**
     * Get category-specific prompt
     */
    protected function getCategoryPrompt(?int $categoryId): ?string
    {
        if (!$categoryId) {
            return null;
        }
        
        $category = Category::find($categoryId);
        
        if (!$category || !$category->custom_prompt) {
            return null;
        }
        
        return "KATEGORIJAS VADLĪNIJAS ({$category->name}):\n" . $category->custom_prompt;
    }

    /**
     * Get editorial guidelines for language
     */
    protected function getGuidelines(int $languageId): string
    {
        $guidelines = Guideline::where('language_id', $languageId)
            ->where('is_active', true)
            ->get();
        
        if ($guidelines->isEmpty()) {
            return '';
        }
        
        $content = '';
        foreach ($guidelines as $guideline) {
            if ($guideline->extracted_content) {
                $content .= "## {$guideline->title}\n";
                $content .= substr($guideline->extracted_content, 0, 2000); // Limit to 2000 chars per guideline
                $content .= "\n\n";
            }
        }
        
        return $content;
    }

    /**
     * Get example articles from knowledge base
     */
    protected function getExamples(int $languageId, ?int $categoryId): string
    {
        $query = KnowledgeBase::where('is_active', true)
            ->where('language_id', $languageId);
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        $examples = $query->limit(3)->get();
        
        if ($examples->isEmpty()) {
            return '';
        }
        
        $content = '';
        foreach ($examples as $example) {
            $content .= "### {$example->title}\n";
            $content .= substr($example->content, 0, 1000); // First 1000 chars
            if ($example->notes) {
                $content .= "\n*Kāpēc šis ir labs piemērs: {$example->notes}*";
            }
            $content .= "\n\n";
        }
        
        return $content;
    }

    /**
     * Get analysis requirements
     */
    protected function getAnalysisRequirements(): string
    {
        $threshold = SystemSetting::get('complex_sentence_threshold', 25);
        
        return "ANALĪZES PRASĪBAS:
1. Identificē sarežģītus teikumus (vairāk par {$threshold} vārdiem vai ar vairākiem palīgteikumiem)
2. Sniedz konkrētus ieteikumus teksta uzlabošanai
3. Norādi, ko tekstā varētu dzēst vai saīsināt (atkārtojumi, mazsvarīga informācija)
4. Izveido kopsavilkumu bullet-point formātā
5. Vērtē teksta lasāmību, skaidrību un struktūru";
    }

    /**
     * Get output format requirements
     */
    protected function getOutputFormat(): string
    {
        return 'ATBILDES FORMĀTS:
Lūdzu, atbildi JSON formātā ar šādu struktūru:

```json
{
  "improvements": [
    "Ieteikums 1 ar konkrētu piemēru",
    "Ieteikums 2 ar konkrētu piemēru"
  ],
  "redundancies": [
    "Ko varētu dzēst vai saīsināt 1",
    "Ko varētu dzēst vai saīsināt 2"
  ],
  "summary": "Bullet-point kopsavilkums:\n• Galvenā atziņa 1\n• Galvenā atziņa 2\n• Galvenā atziņa 3",
  "full_analysis": "Pilna analīze ar detalizētu vērtējumu par teksta kvalitāti"
}
```

Atbildi TIKAI ar JSON, bez papildus teksta.';
    }
}

