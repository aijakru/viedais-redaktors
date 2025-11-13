<template>
  <div class="max-w-6xl">
    <div class="card mb-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">
        Zināšanu Bāzes Pārvaldība
      </h2>
      
      <p class="text-sm text-gray-600 mb-6">
        Pievienojiet labas kvalitātes rakstu piemērus, ko AI izmantos kā etalonus analīzē.
      </p>

      <!-- Add Entry Form -->
      <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Nosaukums
          </label>
          <input
            v-model="form.title"
            type="text"
            class="input"
            placeholder="Piem., Laba sporta ziņa"
          />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Valoda
            </label>
            <select v-model="form.language_id" class="select">
              <option :value="null">-- Izvēlieties --</option>
              <option :value="1">Latviešu</option>
              <option :value="2">Русский</option>
              <option :value="3">English</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Kategorija
            </label>
            <select v-model="form.category_id" class="select">
              <option :value="null">-- Izvēlieties --</option>
              <option :value="1">Ziņa</option>
              <option :value="2">Raksts</option>
              <option :value="3">Intervija</option>
              <option :value="4">Komentārs</option>
              <option :value="5">Sports</option>
              <option :value="6">Politika</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Raksta Saturs
          </label>
          <textarea
            v-model="form.content"
            class="textarea min-h-[200px]"
            placeholder="Iekopējiet raksta tekstu..."
          ></textarea>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Piezīmes (Kāpēc šis ir labs piemērs?)
          </label>
          <textarea
            v-model="form.notes"
            class="textarea min-h-[80px]"
            placeholder="Piem., Īss, kodolīgs, skaidri strukturēts..."
          ></textarea>
        </div>

        <button
          @click="addEntry"
          :disabled="!canAdd || isAdding"
          class="btn btn-primary w-full"
        >
          <span v-if="isAdding">Pievieno...</span>
          <span v-else>Pievienot Piemēru</span>
        </button>
      </div>
    </div>

    <!-- Knowledge Base List -->
    <div class="card">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Piemēru Saraksts</h3>
      
      <div v-if="entries.length === 0" class="text-center py-8 text-gray-500">
        Nav pievienotu piemēru
      </div>

      <div v-else class="space-y-4">
        <div
          v-for="entry in entries"
          :key="entry.id"
          class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
        >
          <div class="flex justify-between items-start mb-2">
            <h4 class="text-base font-semibold text-gray-900">{{ entry.title }}</h4>
            <button
              @click="deleteEntry(entry.id)"
              class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
              title="Dzēst"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>

          <div class="flex gap-2 text-xs text-gray-600 mb-3">
            <span v-if="entry.language" class="px-2 py-1 bg-blue-100 text-blue-700 rounded">
              {{ entry.language.name }}
            </span>
            <span v-if="entry.category" class="px-2 py-1 bg-green-100 text-green-700 rounded">
              {{ entry.category.name }}
            </span>
          </div>

          <p class="text-sm text-gray-700 mb-2 line-clamp-3">
            {{ entry.content.substring(0, 200) }}{{ entry.content.length > 200 ? '...' : '' }}
          </p>

          <p v-if="entry.notes" class="text-xs text-gray-600 italic">
            💡 {{ entry.notes }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const entries = ref([]);
const isAdding = ref(false);

const form = ref({
  title: '',
  content: '',
  language_id: null,
  category_id: null,
  notes: ''
});

const canAdd = computed(() => {
  return form.value.title && form.value.content;
});

const addEntry = async () => {
  if (!canAdd.value) return;

  isAdding.value = true;

  try {
    const response = await axios.post('/admin/knowledge-base', form.value);

    if (response.data.success) {
      entries.value.unshift(response.data.entry);
      
      // Reset form
      form.value = {
        title: '',
        content: '',
        language_id: null,
        category_id: null,
        notes: ''
      };
      
      alert('Piemērs veiksmīgi pievienots!');
    }
  } catch (error) {
    console.error('Add failed:', error);
    alert('Pievienošana neizdevās: ' + (error.response?.data?.error || error.message));
  } finally {
    isAdding.value = false;
  }
};

const deleteEntry = async (id) => {
  if (!confirm('Vai tiešām vēlaties dzēst šo piemēru?')) return;

  try {
    await axios.delete(`/admin/knowledge-base/${id}`);
    entries.value = entries.value.filter(e => e.id !== id);
  } catch (error) {
    console.error('Delete failed:', error);
    alert('Dzēšana neizdevās');
  }
};

const loadEntries = async () => {
  try {
    const response = await axios.get('/admin/knowledge-base');
    entries.value = response.data.knowledgeBase || [];
  } catch (error) {
    console.error('Failed to load entries:', error);
  }
};

onMounted(() => {
  loadEntries();
});
</script>

