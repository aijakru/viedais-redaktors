<template>
  <div class="card">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">2. Teksta Iestatījumi</h2>
    
    <div class="space-y-4">
      <!-- Language Selection -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Valoda *
        </label>
        <select
          :value="language"
          @change="$emit('update:language', parseInt($event.target.value))"
          class="select"
          required
        >
          <option v-for="lang in languages" :key="lang.id" :value="lang.id">
            {{ lang.name }}
          </option>
        </select>
      </div>

      <!-- Category Selection -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Kategorija
        </label>
        <select
          :value="category"
          @change="$emit('update:category', $event.target.value ? parseInt($event.target.value) : null)"
          class="select"
        >
          <option :value="null">-- Izvēlieties kategoriju --</option>
          <option v-for="cat in categories" :key="cat.id" :value="cat.id">
            {{ cat.name }}
          </option>
        </select>
        <p class="mt-1 text-xs text-gray-500">
          Kategorija palīdz sistēmai labāk novērtēt tekstu pēc specifiskiem standartiem
        </p>
      </div>

      <!-- Style Selection -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Stils
        </label>
        <select
          :value="style"
          @change="$emit('update:style', $event.target.value || null)"
          class="select"
        >
          <option :value="null">-- Izvēlieties stilu --</option>
          <option value="news">Ziņa</option>
          <option value="article">Raksts</option>
          <option value="interview">Intervija</option>
          <option value="opinion">Viedoklis</option>
          <option value="feature">Reportāža</option>
        </select>
      </div>

      <!-- Info Box -->
      <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
          <svg class="h-5 w-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div class="text-sm text-blue-800">
            <p class="font-medium mb-1">Kā tas darbojas?</p>
            <p>Sistēma izmanto izvēlēto valodu, kategoriju un stilu, lai pielāgotu analīzi jūsu teksta specifikai un redakcionālajām vadlīnijām.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
  language: {
    type: Number,
    default: 1,
  },
  category: {
    type: Number,
    default: null,
  },
  style: {
    type: String,
    default: null,
  },
});

defineEmits(['update:language', 'update:category', 'update:style']);

const languages = ref([
  { id: 1, code: 'lv', name: 'Latviešu' },
  { id: 2, code: 'ru', name: 'Русский' },
  { id: 3, code: 'en', name: 'English' },
]);

const categories = ref([
  { id: 1, name: 'Ziņa', slug: 'news' },
  { id: 2, name: 'Raksts', slug: 'article' },
  { id: 3, name: 'Intervija', slug: 'interview' },
  { id: 4, name: 'Komentārs', slug: 'commentary' },
  { id: 5, name: 'Sports', slug: 'sports' },
  { id: 6, name: 'Politika', slug: 'politics' },
]);

onMounted(async () => {
  // In a full implementation, load categories from API
  // try {
  //   const response = await axios.get('/admin/categories');
  //   categories.value = response.data;
  // } catch (error) {
  //   console.error('Failed to load categories:', error);
  // }
});
</script>

