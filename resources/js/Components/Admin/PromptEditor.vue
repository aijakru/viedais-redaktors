<template>
  <div class="max-w-4xl">
    <div class="card">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">
        Sistēmas Prompts Rediģēšana
      </h2>
      
      <p class="text-sm text-gray-600 mb-6">
        Šis prompts nosaka, kā AI modelis analizē tekstus. Pielāgojiet to atbilstoši savām vajadzībām.
      </p>

      <!-- Prompt Editor -->
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Sistēmas Prompts
          </label>
          <textarea
            v-model="promptText"
            class="textarea min-h-[400px] font-mono text-sm"
            placeholder="Ievadiet sistēmas promptu..."
          ></textarea>
          <p class="mt-2 text-xs text-gray-500">
            {{ promptText.length }} rakstzīmes
          </p>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end gap-3">
          <button
            @click="loadPrompt"
            class="btn btn-secondary"
            :disabled="isSaving"
          >
            Atjaunot
          </button>
          <button
            @click="savePrompt"
            class="btn btn-primary"
            :disabled="isSaving || !hasChanges"
          >
            <span v-if="isSaving">Saglabā...</span>
            <span v-else>Saglabāt Izmaiņas</span>
          </button>
        </div>

        <!-- Success Message -->
        <div v-if="showSuccess" class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
          ✓ Prompts veiksmīgi saglabāts!
        </div>
      </div>

      <!-- Preview Section -->
      <div class="mt-8 pt-8 border-t border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Preview</h3>
        <div class="p-4 bg-gray-50 rounded-lg">
          <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ promptText }}</pre>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const promptText = ref('');
const originalPrompt = ref('');
const isSaving = ref(false);
const showSuccess = ref(false);

const hasChanges = computed(() => {
  return promptText.value !== originalPrompt.value;
});

const loadPrompt = async () => {
  try {
    const response = await axios.get('/admin/settings/prompt');
    promptText.value = response.data.prompt || '';
    originalPrompt.value = response.data.prompt || '';
  } catch (error) {
    console.error('Failed to load prompt:', error);
    alert('Neizdevās ielādēt promptu');
  }
};

const savePrompt = async () => {
  isSaving.value = true;
  showSuccess.value = false;

  try {
    await axios.post('/admin/settings/prompt', {
      prompt: promptText.value
    });

    originalPrompt.value = promptText.value;
    showSuccess.value = true;

    setTimeout(() => {
      showSuccess.value = false;
    }, 3000);
  } catch (error) {
    console.error('Failed to save prompt:', error);
    alert('Neizdevās saglabāt promptu');
  } finally {
    isSaving.value = false;
  }
};

onMounted(() => {
  loadPrompt();
});
</script>

