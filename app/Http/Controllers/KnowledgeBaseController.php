<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeBase;
use App\Models\Language;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KnowledgeBaseController extends Controller
{
    /**
     * Display knowledge base management page
     */
    public function index()
    {
        $knowledgeBase = KnowledgeBase::with(['language', 'category'])
            ->orderBy('created_at', 'desc')
            ->get();

        $languages = Language::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        return Inertia::render('Admin/KnowledgeBase', [
            'knowledgeBase' => $knowledgeBase,
            'languages' => $languages,
            'categories' => $categories,
        ]);
    }

    /**
     * Store new knowledge base entry
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'language_id' => 'nullable|exists:languages,id',
            'category_id' => 'nullable|exists:categories,id',
            'notes' => 'nullable|string',
        ]);

        $entry = KnowledgeBase::create([
            ...$validated,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'entry' => $entry->load(['language', 'category'])
        ]);
    }

    /**
     * Delete knowledge base entry
     */
    public function destroy($id)
    {
        $entry = KnowledgeBase::findOrFail($id);
        $entry->delete();

        return response()->json([
            'success' => true
        ]);
    }
}

