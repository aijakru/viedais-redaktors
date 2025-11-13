<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SystemSettingsController extends Controller
{
    /**
     * Display system settings page
     */
    public function index()
    {
        $settings = SystemSetting::all();
        
        return Inertia::render('Admin/Settings', [
            'settings' => $settings
        ]);
    }

    /**
     * Update system settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable|string',
        ]);

        foreach ($validated['settings'] as $setting) {
            SystemSetting::set($setting['key'], $setting['value']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully'
        ]);
    }

    /**
     * Get system prompt
     */
    public function getPrompt()
    {
        $prompt = SystemSetting::get('system_prompt', '');

        return response()->json([
            'prompt' => $prompt
        ]);
    }

    /**
     * Update system prompt
     */
    public function updatePrompt(Request $request)
    {
        $validated = $request->validate([
            'prompt' => 'required|string',
        ]);

        SystemSetting::set('system_prompt', $validated['prompt']);

        return response()->json([
            'success' => true,
            'message' => 'Prompt updated successfully'
        ]);
    }

    /**
     * Get all categories
     */
    public function getCategories()
    {
        $categories = Category::orderBy('name')->get();

        return response()->json($categories);
    }

    /**
     * Store new category
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'custom_prompt' => 'nullable|string',
        ]);

        $category = Category::create([
            ...$validated,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    /**
     * Delete category
     */
    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true
        ]);
    }
}

