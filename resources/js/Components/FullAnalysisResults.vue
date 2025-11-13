<template>
  <div class="space-y-6">
    <!-- Complex Sentences -->
    <div v-if="hasComplexSentences" class="card">
      <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <svg class="h-5 w-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        Sarežģīti Teikumi
      </h3>
      <div class="space-y-3">
        <div
          v-for="(sentence, index) in analysis.complex_sentences"
          :key="index"
          class="p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded"
        >
          <p class="text-sm text-gray-800 mb-2">{{ sentence.sentence }}</p>
          <p class="text-xs text-yellow-700 font-medium">
            {{ sentence.word_count }} vārdi teikumā
          </p>
        </div>
      </div>
    </div>

    <!-- Improvements -->
    <div v-if="hasImprovements" class="card">
      <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <svg class="h-5 w-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z" />
        </svg>
        Ieteikumi Uzlabojumiem
      </h3>
      <ul class="space-y-3">
        <li
          v-for="(improvement, index) in analysis.improvements"
          :key="index"
          class="flex items-start p-3 bg-blue-50 rounded-lg"
        >
          <span class="flex-shrink-0 inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-500 text-white text-xs font-medium mr-3">
            {{ index + 1 }}
          </span>
          <p class="text-sm text-gray-800">{{ improvement }}</p>
        </li>
      </ul>
    </div>

    <!-- Redundancies -->
    <div v-if="hasRedundancies" class="card">
      <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <svg class="h-5 w-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
        </svg>
        Ko Varētu Dzēst vai Saīsināt
      </h3>
      <ul class="space-y-3">
        <li
          v-for="(redundancy, index) in analysis.redundancies"
          :key="index"
          class="flex items-start p-3 bg-red-50 rounded-lg"
        >
          <svg class="flex-shrink-0 h-5 w-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
          <p class="text-sm text-gray-800">{{ redundancy }}</p>
        </li>
      </ul>
    </div>

    <!-- Summary -->
    <div v-if="analysis.summary" class="card">
      <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
          <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
        </svg>
        Kopsavilkums
      </h3>
      <div class="prose prose-sm max-w-none">
        <div class="p-4 bg-green-50 rounded-lg text-gray-800 whitespace-pre-line">
          {{ analysis.summary }}
        </div>
      </div>
    </div>

    <!-- Full Analysis -->
    <div v-if="analysis.full_analysis" class="card">
      <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <svg class="h-5 w-5 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
        </svg>
        Detalizēta Analīze
      </h3>
      <div class="prose prose-sm max-w-none">
        <div class="p-4 bg-gray-50 rounded-lg text-gray-800 whitespace-pre-line">
          {{ analysis.full_analysis }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  analysis: {
    type: Object,
    required: true,
  },
});

const hasComplexSentences = computed(() => {
  return Array.isArray(props.analysis.complex_sentences) && 
         props.analysis.complex_sentences.length > 0;
});

const hasImprovements = computed(() => {
  return Array.isArray(props.analysis.improvements) && 
         props.analysis.improvements.length > 0;
});

const hasRedundancies = computed(() => {
  return Array.isArray(props.analysis.redundancies) && 
         props.analysis.redundancies.length > 0;
});
</script>

