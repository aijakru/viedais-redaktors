<template>
  <div class="max-w-6xl">
    <div class="card mb-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">
        Kategoriju Pārvaldība
      </h2>
      
      <p class="text-sm text-gray-600 mb-6">
        Pārvaldiet kategorijas un pielāgojiet specifiskus promptus katrai kategorijai.
      </p>

      <!-- Add Category Form -->
      <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Nosaukums
            </label>
            <input
              v-model="form.name"
              type="text"
              class="input"
              placeholder="Piem., Kultūra"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Slug (URL draudzīgs)
            </label>
            <input
              v-model="form.slug"
              type="text"
              class="input"
              placeholder="Piem., kultura"
            />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Apraksts
          </label>
          <input
            v-model="form.description"
            type="text"
            class="input"
            placeholder="Īss kategorijas apraksts"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Kategorijas Specifiskais Prompts (neobligāts)
          </label>
          <textarea
            v-model="form.custom_prompt"
            class="textarea min-h-[120px]"
            placeholder="Specifiskas instrukcijas šai kategorijai..."
          ></textarea>
          <p class="mt-1 text-xs text-gray-500">
            Šis prompts tiks pievienots sistēmas promptam, analizējot šīs kategorijas tekstus
          </p>
        </div>

        <button
          @click="addCategory"
          :disabled="!canAdd || isAdding"
          class="btn btn-primary w-full"
        >
          <span v-if="isAdding">Pievieno...</span>
          <span v-else>Pievienot Kategoriju</span>
        </button>
      </div>
    </div>

    <!-- Categories List -->
    <div class="card">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Esošās Kategorijas</h3>
      
      <div class="space-y-3">
        <div
          v-for="category in categories"
          :key="category.id"
          class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
        >
          <div class="flex justify-between items-start">
            <div class="flex-1">
              <div class="flex items-center gap-3 mb-2">
                <h4 class="text-base font-semibold text-gray-900">{{ category.name }}</h4>
                <span class="px-2 py-1 text-xs bg-gray-200 text-gray-700 rounded">
                  {{ category.slug }}
                </span>
              </div>
              
              <p v-if="category.description" class="text-sm text-gray-600 mb-2">
                {{ category.description }}
              </p>

              <div v-if="category.custom_prompt" class="mt-3 p-3 bg-white rounded border border-gray-200">
                <p class="text-xs font-medium text-gray-700 mb-1">Specifiskais Prompts:</p>
                <p class="text-xs text-gray-600">{{ category.custom_prompt }}</p>
              </div>
            </div>

            <button
              v-if="category.id > 6"
              @click="deleteCategory(category.id)"
              class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors ml-4"
              title="Dzēst"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
            <span v-else class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded ml-4">
              Noklusējuma
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const categories = ref([]);
const isAdding = ref(false);

const form = ref({
  name: '',
  slug: '',
  description: '',
  custom_prompt: ''
});

const canAdd = computed(() => {
  return form.value.name && form.value.slug;
});

const addCategory = async () => {
  if (!canAdd.value) return;

  isAdding.value = true;

  try {
    const response = await axios.post('/admin/categories', form.value);

    if (response.data.success) {
      categories.value.push(response.data.category);
      
      // Reset form
      form.value = {
        name: '',
        slug: '',
        description: '',
        custom_prompt: ''
      };
      
      alert('Kategorija veiksmīgi pievienota!');
    }
  } catch (error) {
    console.error('Add failed:', error);
    alert('Pievienošana neizdevās: ' + (error.response?.data?.error || error.message));
  } finally {
    isAdding.value = false;
  }
};

const deleteCategory = async (id) => {
  if (!confirm('Vai tiešām vēlaties dzēst šo kategoriju?')) return;

  try {
    await axios.delete(`/admin/categories/${id}`);
    categories.value = categories.value.filter(c => c.id !== id);
  } catch (error) {
    console.error('Delete failed:', error);
    alert('Dzēšana neizdevās');
  }
};

const loadCategories = async () => {
  try {
    const response = await axios.get('/admin/categories');
    categories.value = response.data;
  } catch (error) {
    console.error('Failed to load categories:', error);
  }
};

onMounted(() => {
  loadCategories();
});
</script>

