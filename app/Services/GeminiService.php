<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $model;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->model = env('GEMINI_MODEL', 'gemini-2.0-flash-exp');
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    /**
     * Analyze text using Gemini API
     */
    public function analyzeText(string $prompt): array
    {
        try {
            $response = Http::timeout(60)
                ->post($this->apiUrl . "?key={$this->apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 4096,
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return [
                        'success' => true,
                        'text' => $data['candidates'][0]['content']['parts'][0]['text'],
                        'raw' => $data
                    ];
                }
                
                return [
                    'success' => false,
                    'error' => 'Invalid response format',
                    'raw' => $data
                ];
            }

            return [
                'success' => false,
                'error' => 'API request failed',
                'status' => $response->status(),
                'body' => $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Parse JSON response from Gemini
     */
    public function parseJsonResponse(string $text): ?array
    {
        // Try to extract JSON from markdown code blocks
        if (preg_match('/```json\s*(.*?)\s*```/s', $text, $matches)) {
            $text = $matches[1];
        }
        
        // Try to parse JSON
        $decoded = json_decode($text, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }
        
        return null;
    }

    /**
     * Test API connection
     */
    public function testConnection(): array
    {
        return $this->analyzeText('Test connection. Respond with "OK".');
    }
}

