<template>
  <div class="card">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">3. Analīzes Rezultāti</h2>
    
    <!-- Overall Score -->
    <div class="mb-6">
      <div :class="['metric-card', scoreClass]">
        <div class="flex items-center justify-between">
          <span class="text-sm font-medium text-gray-600">Kopējais Vērtējums</span>
          <span :class="['text-2xl font-bold', scoreTextClass]">
            {{ scoreLabel }}
          </span>
        </div>
      </div>
    </div>

    <!-- Key Metrics -->
    <div class="space-y-3">
      <!-- Readability Score -->
      <div class="metric-card">
        <div class="flex justify-between items-center">
          <span class="text-sm font-medium text-gray-700">Lasāmības Indekss</span>
          <span class="text-lg font-semibold text-gray-900">
            {{ analysis.readability_score }}
          </span>
        </div>
        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
          <div
            :class="['h-2 rounded-full transition-all', readabilityBarClass]"
            :style="{ width: `${Math.min(100, analysis.readability_score)}%` }"
          ></div>
        </div>
      </div>

      <!-- Word Count -->
      <div class="metric-card">
        <div class="flex justify-between items-center">
          <span class="text-sm text-gray-600">Vārdu skaits</span>
          <span class="text-lg font-semibold text-gray-900">
            {{ analysis.word_count }}
          </span>
        </div>
      </div>

      <!-- Sentence Count -->
      <div class="metric-card">
        <div class="flex justify-between items-center">
          <span class="text-sm text-gray-600">Teikumu skaits</span>
          <span class="text-lg font-semibold text-gray-900">
            {{ analysis.sentence_count }}
          </span>
        </div>
      </div>

      <!-- Avg Words Per Sentence -->
      <div class="metric-card">
        <div class="flex justify-between items-center">
          <span class="text-sm text-gray-600">Vidēji vārdi teikumā</span>
          <span class="text-lg font-semibold text-gray-900">
            {{ analysis.avg_words_per_sentence }}
          </span>
        </div>
      </div>

      <!-- Paragraph Count -->
      <div class="metric-card">
        <div class="flex justify-between items-center">
          <span class="text-sm text-gray-600">Rindkopu skaits</span>
          <span class="text-lg font-semibold text-gray-900">
            {{ analysis.paragraph_count }}
          </span>
        </div>
      </div>

      <!-- Complex Sentences Count -->
      <div v-if="complexSentencesCount > 0" :class="['metric-card', 'metric-warning']">
        <div class="flex justify-between items-center">
          <span class="text-sm font-medium text-gray-700">Sarežģīti teikumi</span>
          <span class="text-lg font-semibold text-yellow-700">
            {{ complexSentencesCount }}
          </span>
        </div>
        <p class="mt-1 text-xs text-gray-600">
          Teikumi ar vairāk par 25 vārdiem
        </p>
      </div>
    </div>

    <!-- Quick Insights -->
    <div class="mt-6 pt-6 border-t border-gray-200">
      <h3 class="text-sm font-medium text-gray-900 mb-3">Ātrais Novērtējums</h3>
      <div class="space-y-2 text-sm">
        <div class="flex items-start">
          <svg :class="['h-5 w-5 mr-2', readabilityIconClass]" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
          <span class="text-gray-700">{{ readabilityMessage }}</span>
        </div>
        <div class="flex items-start">
          <svg :class="['h-5 w-5 mr-2', sentenceLengthIconClass]" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
          <span class="text-gray-700">{{ sentenceLengthMessage }}</span>
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

const complexSentencesCount = computed(() => {
  return Array.isArray(props.analysis.complex_sentences) 
    ? props.analysis.complex_sentences.length 
    : 0;
});

const scoreClass = computed(() => {
  const score = props.analysis.overall_score;
  if (score === 'good') return 'metric-good';
  if (score === 'warning') return 'metric-warning';
  return 'metric-danger';
});

const scoreTextClass = computed(() => {
  const score = props.analysis.overall_score;
  if (score === 'good') return 'text-green-600';
  if (score === 'warning') return 'text-yellow-600';
  return 'text-red-600';
});

const scoreLabel = computed(() => {
  const score = props.analysis.overall_score;
  if (score === 'good') return 'Labs';
  if (score === 'warning') return 'Vidējs';
  return 'Uzmanību';
});

const readabilityBarClass = computed(() => {
  const score = props.analysis.readability_score;
  if (score >= 60) return 'bg-green-500';
  if (score >= 40) return 'bg-yellow-500';
  return 'bg-red-500';
});

const readabilityIconClass = computed(() => {
  const score = props.analysis.readability_score;
  if (score >= 60) return 'text-green-500';
  if (score >= 40) return 'text-yellow-500';
  return 'text-red-500';
});

const readabilityMessage = computed(() => {
  const score = props.analysis.readability_score;
  if (score >= 60) return 'Teksts ir viegli lasāms';
  if (score >= 40) return 'Teksts ir vidēji lasāms';
  return 'Teksts ir grūti lasāms';
});

const sentenceLengthIconClass = computed(() => {
  const avg = props.analysis.avg_words_per_sentence;
  if (avg <= 20) return 'text-green-500';
  if (avg <= 25) return 'text-yellow-500';
  return 'text-red-500';
});

const sentenceLengthMessage = computed(() => {
  const avg = props.analysis.avg_words_per_sentence;
  if (avg <= 20) return 'Teikumi ir optimāla garuma';
  if (avg <= 25) return 'Teikumi ir nedaudz gari';
  return 'Teikumi ir pārāk gari';
});
</script>

