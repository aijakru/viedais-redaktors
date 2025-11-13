<?php

namespace App\Http\Controllers;

use App\Models\Guideline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GuidelineController extends Controller
{
    /**
     * Display guidelines management page
     */
    public function index()
    {
        $guidelines = Guideline::with('language')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/Guidelines', [
            'guidelines' => $guidelines
        ]);
    }

    /**
     * Store new guideline file
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,txt,doc,docx|max:10240', // Max 10MB
            'language_id' => 'nullable|exists:languages,id',
        ]);

        try {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('guidelines', $filename, 'local');

            // Extract text content from file
            $extractedContent = $this->extractTextFromFile($file);

            $guideline = Guideline::create([
                'title' => $validated['title'],
                'filename' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'extracted_content' => $extractedContent,
                'language_id' => $validated['language_id'] ?? null,
                'is_active' => true,
            ]);

            return response()->json([
                'success' => true,
                'guideline' => $guideline->load('language')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to upload guideline: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete guideline
     */
    public function destroy($id)
    {
        $guideline = Guideline::findOrFail($id);
        
        // Delete file from storage
        if (Storage::exists($guideline->file_path)) {
            Storage::delete($guideline->file_path);
        }

        $guideline->delete();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Download guideline file
     */
    public function download($id)
    {
        $guideline = Guideline::findOrFail($id);

        if (!Storage::exists($guideline->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::download($guideline->file_path, $guideline->filename);
    }

    /**
     * Extract text from uploaded file
     */
    protected function extractTextFromFile($file): ?string
    {
        $extension = $file->getClientOriginalExtension();

        try {
            if ($extension === 'txt') {
                return file_get_contents($file->getRealPath());
            }

            if ($extension === 'pdf') {
                // For PDF extraction, you'd need a library like smalot/pdfparser
                // For now, return a placeholder
                return "PDF content extraction requires additional library. File uploaded successfully.";
            }

            if (in_array($extension, ['doc', 'docx'])) {
                // For DOCX extraction, you'd need a library like phpoffice/phpword
                return "DOCX content extraction requires additional library. File uploaded successfully.";
            }

            return null;

        } catch (\Exception $e) {
            return null;
        }
    }
}

