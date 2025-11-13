<template>
  <div class="max-w-6xl">
    <div class="card mb-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">
        Vadlīniju Pārvaldība
      </h2>
      
      <p class="text-sm text-gray-600 mb-6">
        Augšupielādējiet redakcionālās vadlīnijas, kas tiks izmantotas teksta analīzē.
      </p>

      <!-- Upload Form -->
      <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-primary-400 transition-colors">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Nosaukums
            </label>
            <input
              v-model="uploadForm.title"
              type="text"
              class="input"
              placeholder="Piem., Delfi Redakcionālās Vadlīnijas 2024"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Valoda
            </label>
            <select v-model="uploadForm.language_id" class="select">
              <option :value="null">-- Nav norādīta --</option>
              <option :value="1">Latviešu</option>
              <option :value="2">Русский</option>
              <option :value="3">English</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Fails (PDF, TXT, DOC, DOCX)
            </label>
            <input
              type="file"
              @change="handleFileSelect"
              accept=".pdf,.txt,.doc,.docx"
              class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-lg file:border-0
                file:text-sm file:font-medium
                file:bg-primary-50 file:text-primary-700
                hover:file:bg-primary-100"
            />
          </div>

          <button
            @click="uploadGuideline"
            :disabled="!canUpload || isUploading"
            class="btn btn-primary w-full"
          >
            <span v-if="isUploading">Augšupielādē...</span>
            <span v-else>Augšupielādēt Vadlīnijas</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Guidelines List -->
    <div class="card">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Augšupielādētās Vadlīnijas</h3>
      
      <div v-if="guidelines.length === 0" class="text-center py-8 text-gray-500">
        Nav augšupielādētu vadlīniju
      </div>

      <div v-else class="space-y-3">
        <div
          v-for="guideline in guidelines"
          :key="guideline.id"
          class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
        >
          <div class="flex items-center flex-1">
            <svg class="h-8 w-8 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
            </svg>
            <div>
              <h4 class="text-sm font-medium text-gray-900">{{ guideline.title }}</h4>
              <p class="text-xs text-gray-500 mt-1">
                {{ guideline.filename }} 
                <span v-if="guideline.language">({{ guideline.language.name }})</span>
                • {{ formatFileSize(guideline.file_size) }}
              </p>
            </div>
          </div>

          <div class="flex gap-2">
            <button
              @click="downloadGuideline(guideline.id)"
              class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
              title="Lejupielādēt"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
            </button>
            <button
              @click="deleteGuideline(guideline.id)"
              class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
              title="Dzēst"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const guidelines = ref([]);
const isUploading = ref(false);

const uploadForm = ref({
  title: '',
  language_id: null,
  file: null
});

const canUpload = computed(() => {
  return uploadForm.value.title && uploadForm.value.file;
});

const handleFileSelect = (event) => {
  uploadForm.value.file = event.target.files[0];
};

const uploadGuideline = async () => {
  if (!canUpload.value) return;

  isUploading.value = true;

  try {
    const formData = new FormData();
    formData.append('title', uploadForm.value.title);
    formData.append('file', uploadForm.value.file);
    if (uploadForm.value.language_id) {
      formData.append('language_id', uploadForm.value.language_id);
    }

    const response = await axios.post('/admin/guidelines', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });

    if (response.data.success) {
      guidelines.value.unshift(response.data.guideline);
      
      // Reset form
      uploadForm.value = {
        title: '',
        language_id: null,
        file: null
      };
      
      // Reset file input
      event.target.value = '';
      
      alert('Vadlīnijas veiksmīgi augšupielādētas!');
    }
  } catch (error) {
    console.error('Upload failed:', error);
    alert('Augšupielāde neizdevās: ' + (error.response?.data?.error || error.message));
  } finally {
    isUploading.value = false;
  }
};

const deleteGuideline = async (id) => {
  if (!confirm('Vai tiešām vēlaties dzēst šīs vadlīnijas?')) return;

  try {
    await axios.delete(`/admin/guidelines/${id}`);
    guidelines.value = guidelines.value.filter(g => g.id !== id);
  } catch (error) {
    console.error('Delete failed:', error);
    alert('Dzēšana neizdevās');
  }
};

const downloadGuideline = (id) => {
  window.location.href = `/admin/guidelines/${id}/download`;
};

const formatFileSize = (bytes) => {
  if (bytes < 1024) return bytes + ' B';
  if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
  return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
};

const loadGuidelines = async () => {
  try {
    const response = await axios.get('/admin/guidelines');
    guidelines.value = response.data;
  } catch (error) {
    console.error('Failed to load guidelines:', error);
  }
};

onMounted(() => {
  loadGuidelines();
});
</script>

