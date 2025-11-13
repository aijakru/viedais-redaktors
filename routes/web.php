<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TextAnalysisController;
use App\Http\Controllers\GuidelineController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\SystemSettingsController;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// Text Analysis Routes
Route::post('/analyze', [TextAnalysisController::class, 'analyze'])->name('analyze');
Route::get('/analyses', [TextAnalysisController::class, 'index'])->name('analyses.index');
Route::get('/analyses/{id}', [TextAnalysisController::class, 'show'])->name('analyses.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Guidelines Management
    Route::get('/guidelines', [GuidelineController::class, 'index'])->name('guidelines.index');
    Route::post('/guidelines', [GuidelineController::class, 'store'])->name('guidelines.store');
    Route::delete('/guidelines/{id}', [GuidelineController::class, 'destroy'])->name('guidelines.destroy');
    Route::get('/guidelines/{id}/download', [GuidelineController::class, 'download'])->name('guidelines.download');
    
    // Knowledge Base Management
    Route::get('/knowledge-base', [KnowledgeBaseController::class, 'index'])->name('knowledge-base.index');
    Route::post('/knowledge-base', [KnowledgeBaseController::class, 'store'])->name('knowledge-base.store');
    Route::delete('/knowledge-base/{id}', [KnowledgeBaseController::class, 'destroy'])->name('knowledge-base.destroy');
    
    // System Settings
    Route::get('/settings', [SystemSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SystemSettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/prompt', [SystemSettingsController::class, 'getPrompt'])->name('settings.prompt');
    Route::post('/settings/prompt', [SystemSettingsController::class, 'updatePrompt'])->name('settings.prompt.update');
    
    // Categories
    Route::get('/categories', [SystemSettingsController::class, 'getCategories'])->name('categories.index');
    Route::post('/categories', [SystemSettingsController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{id}', [SystemSettingsController::class, 'destroyCategory'])->name('categories.destroy');
});

