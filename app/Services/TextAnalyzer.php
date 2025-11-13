<?php

namespace App\Services;

class TextAnalyzer
{
    /**
     * Calculate all metrics for given text
     */
    public function analyze(string $text): array
    {
        // Clean the text
        $cleanText = $this->cleanText($text);
        
        return [
            'word_count' => $this->countWords($cleanText),
            'sentence_count' => $this->countSentences($cleanText),
            'paragraph_count' => $this->countParagraphs($text),
            'avg_words_per_sentence' => $this->calculateAvgWordsPerSentence($cleanText),
            'readability_score' => $this->calculateReadabilityScore($cleanText),
            'complex_sentences' => $this->findComplexSentences($cleanText),
        ];
    }

    /**
     * Clean text for analysis
     */
    protected function cleanText(string $text): string
    {
        // Remove extra whitespace
        return trim(preg_replace('/\s+/', ' ', $text));
    }

    /**
     * Count words in text
     */
    public function countWords(string $text): int
    {
        $text = $this->cleanText($text);
        if (empty($text)) {
            return 0;
        }
        
        // Use mb_str_word_count for better unicode support
        return count(preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY));
    }

    /**
     * Count sentences in text
     */
    public function countSentences(string $text): int
    {
        if (empty($text)) {
            return 0;
        }
        
        // Split by sentence-ending punctuation
        $sentences = preg_split('/[.!?]+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        return count(array_filter($sentences, function($s) {
            return trim($s) !== '';
        }));
    }

    /**
     * Count paragraphs in text
     */
    public function countParagraphs(string $text): int
    {
        if (empty($text)) {
            return 0;
        }
        
        // Split by double newlines or multiple newlines
        $paragraphs = preg_split('/\n\s*\n/u', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        return count($paragraphs);
    }

    /**
     * Calculate average words per sentence
     */
    public function calculateAvgWordsPerSentence(string $text): float
    {
        $wordCount = $this->countWords($text);
        $sentenceCount = $this->countSentences($text);
        
        if ($sentenceCount === 0) {
            return 0;
        }
        
        return round($wordCount / $sentenceCount, 2);
    }

    /**
     * Calculate readability score (adapted Flesch Reading Ease)
     */
    public function calculateReadabilityScore(string $text): float
    {
        $wordCount = $this->countWords($text);
        $sentenceCount = $this->countSentences($text);
        
        if ($wordCount === 0 || $sentenceCount === 0) {
            return 0;
        }
        
        $avgWordsPerSentence = $wordCount / $sentenceCount;
        $avgSyllablesPerWord = $this->estimateAvgSyllables($text, $wordCount);
        
        // Simplified Flesch Reading Ease formula
        // 206.835 - 1.015 * (words/sentences) - 84.6 * (syllables/words)
        $score = 206.835 - (1.015 * $avgWordsPerSentence) - (84.6 * $avgSyllablesPerWord);
        
        // Clamp between 0 and 100
        return round(max(0, min(100, $score)), 2);
    }

    /**
     * Estimate average syllables per word
     */
    protected function estimateAvgSyllables(string $text, int $wordCount): float
    {
        if ($wordCount === 0) {
            return 0;
        }
        
        // Simple syllable estimation
        // For Latvian/Russian/English - count vowels as rough estimate
        $vowels = preg_match_all('/[aeiouāēīōūАЕЁИОУЫЭЮЯаеёиоуыэюя]/ui', $text);
        
        return $vowels / $wordCount;
    }

    /**
     * Find complex sentences (sentences with > threshold words)
     */
    public function findComplexSentences(string $text, int $threshold = 25): array
    {
        if (empty($text)) {
            return [];
        }
        
        // Split text into sentences
        $sentences = preg_split('/([.!?]+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        
        $complexSentences = [];
        $currentSentence = '';
        
        for ($i = 0; $i < count($sentences); $i++) {
            $currentSentence .= $sentences[$i];
            
            // If we hit punctuation, check if sentence is complete
            if (preg_match('/[.!?]+/', $sentences[$i])) {
                $wordCount = $this->countWords($currentSentence);
                
                if ($wordCount > $threshold) {
                    $complexSentences[] = [
                        'sentence' => trim($currentSentence),
                        'word_count' => $wordCount
                    ];
                }
                
                $currentSentence = '';
            }
        }
        
        return $complexSentences;
    }

    /**
     * Get score classification
     */
    public function getScoreClassification(float $readabilityScore): string
    {
        if ($readabilityScore >= 60) {
            return 'good';
        } elseif ($readabilityScore >= 40) {
            return 'warning';
        } else {
            return 'danger';
        }
    }
}

