<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Models\Analysis;
use App\Services\GeminiService;
use App\Services\TextAnalyzer;
use App\Services\PromptBuilder;
use Illuminate\Http\Request;

class TextAnalysisController extends Controller
{
    protected $geminiService;
    protected $textAnalyzer;
    protected $promptBuilder;

    public function __construct(
        GeminiService $geminiService,
        TextAnalyzer $textAnalyzer,
        PromptBuilder $promptBuilder
    ) {
        $this->geminiService = $geminiService;
        $this->textAnalyzer = $textAnalyzer;
        $this->promptBuilder = $promptBuilder;
    }

    /**
     * Analyze submitted text
     */
    public function analyze(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:10',
            'language_id' => 'required|exists:languages,id',
            'category_id' => 'nullable|exists:categories,id',
            'style' => 'nullable|string',
        ]);

        try {
            // 1. Save text
            $text = Text::create($validated);

            // 2. Calculate basic metrics
            $metrics = $this->textAnalyzer->analyze($validated['content']);

            // 3. Build AI prompt
            $prompt = $this->promptBuilder->buildAnalysisPrompt(
                $validated['content'],
                $validated['language_id'],
                $validated['category_id']
            );

            // 4. Get AI analysis
            $aiResponse = $this->geminiService->analyzeText($prompt);

            if (!$aiResponse['success']) {
                return response()->json([
                    'error' => 'AI analysis failed: ' . ($aiResponse['error'] ?? 'Unknown error')
                ], 500);
            }

            // 5. Parse AI response
            $aiAnalysis = $this->geminiService->parseJsonResponse($aiResponse['text']);
            
            if (!$aiAnalysis) {
                // If JSON parsing fails, use raw text
                $aiAnalysis = [
                    'full_analysis' => $aiResponse['text'],
                    'improvements' => [],
                    'redundancies' => [],
                    'summary' => ''
                ];
            }

            // 6. Save analysis
            $analysis = Analysis::create([
                'text_id' => $text->id,
                'word_count' => $metrics['word_count'],
                'sentence_count' => $metrics['sentence_count'],
                'paragraph_count' => $metrics['paragraph_count'],
                'avg_words_per_sentence' => $metrics['avg_words_per_sentence'],
                'readability_score' => $metrics['readability_score'],
                'complex_sentences' => $metrics['complex_sentences'],
                'improvements' => $aiAnalysis['improvements'] ?? [],
                'redundancies' => $aiAnalysis['redundancies'] ?? [],
                'summary' => $aiAnalysis['summary'] ?? '',
                'full_analysis' => $aiAnalysis['full_analysis'] ?? '',
                'overall_score' => $this->textAnalyzer->getScoreClassification($metrics['readability_score']),
            ]);

            return response()->json([
                'success' => true,
                'text_id' => $text->id,
                'analysis' => $analysis
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Analysis failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all analyses
     */
    public function index()
    {
        $analyses = Analysis::with(['text.language', 'text.category'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($analyses);
    }

    /**
     * Get specific analysis
     */
    public function show($id)
    {
        $analysis = Analysis::with(['text.language', 'text.category'])->findOrFail($id);

        return response()->json($analysis);
    }
}

