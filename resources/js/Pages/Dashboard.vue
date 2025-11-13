<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-bold text-gray-900">Viedais Teksta Redaktors</h1>
          <nav class="flex gap-4">
            <a href="/" class="text-primary-600 font-medium">Analīze</a>
            <a href="/admin/settings" class="text-gray-600 hover:text-gray-900">Iestatījumi</a>
          </nav>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Text Input + Settings -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Text Input Component -->
          <TextInput
            v-model="formData.content"
            @update:modelValue="handleTextChange"
          />

          <!-- Text Settings Component -->
          <TextSettings
            v-model:language="formData.language_id"
            v-model:category="formData.category_id"
            v-model:style="formData.style"
          />

          <!-- Analyze Button -->
          <div class="flex justify-end">
            <button
              @click="analyzeText"
              :disabled="isAnalyzing || !canAnalyze"
              class="btn btn-primary text-lg px-8 py-3 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span v-if="isAnalyzing">
                <svg class="inline animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Analizē...
              </span>
              <span v-else>Analizēt Tekstu</span>
            </button>
          </div>
        </div>

        <!-- Right Column: Analysis Results -->
        <div class="lg:col-span-1">
          <AnalysisResults
            v-if="analysisResult"
            :analysis="analysisResult"
          />
          <div v-else class="card text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p>Ievadiet tekstu un nospiediet "Analizēt Tekstu"</p>
          </div>
        </div>
      </div>

      <!-- Full Analysis Results (appears below after analysis) -->
      <div v-if="analysisResult" class="mt-6">
        <FullAnalysisResults :analysis="analysisResult" />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import TextInput from '../Components/TextInput.vue';
import TextSettings from '../Components/TextSettings.vue';
import AnalysisResults from '../Components/AnalysisResults.vue';
import FullAnalysisResults from '../Components/FullAnalysisResults.vue';

const formData = ref({
  content: '',
  language_id: 1, // Default to Latvian
  category_id: null,
  style: null,
});

const isAnalyzing = ref(false);
const analysisResult = ref(null);

const canAnalyze = computed(() => {
  return formData.value.content.length >= 10 && formData.value.language_id;
});

const handleTextChange = (value) => {
  formData.value.content = value;
};

const analyzeText = async () => {
  if (!canAnalyze.value) return;

  isAnalyzing.value = true;
  analysisResult.value = null;

  try {
    const response = await axios.post('/analyze', formData.value);
    
    if (response.data.success) {
      analysisResult.value = response.data.analysis;
    } else {
      alert('Analīze neizdevās: ' + (response.data.error || 'Nezināma kļūda'));
    }
  } catch (error) {
    console.error('Analysis error:', error);
    alert('Analīze neizdevās: ' + (error.response?.data?.error || error.message));
  } finally {
    isAnalyzing.value = false;
  }
};
</script>

