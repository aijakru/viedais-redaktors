<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-bold text-gray-900">Sistēmas Iestatījumi</h1>
          <nav class="flex gap-4">
            <a href="/" class="text-gray-600 hover:text-gray-900">Analīze</a>
            <a href="/admin/settings" class="text-primary-600 font-medium">Iestatījumi</a>
          </nav>
        </div>
      </div>
    </header>

    <!-- Tabs -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
      <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
          <button
            @click="activeTab = 'prompt'"
            :class="[
              'py-4 px-1 border-b-2 font-medium text-sm',
              activeTab === 'prompt'
                ? 'border-primary-500 text-primary-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
          >
            Sistēmas Prompts
          </button>
          <button
            @click="activeTab = 'guidelines'"
            :class="[
              'py-4 px-1 border-b-2 font-medium text-sm',
              activeTab === 'guidelines'
                ? 'border-primary-500 text-primary-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
          >
            Vadlīnijas
          </button>
          <button
            @click="activeTab = 'knowledge'"
            :class="[
              'py-4 px-1 border-b-2 font-medium text-sm',
              activeTab === 'knowledge'
                ? 'border-primary-500 text-primary-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
          >
            Zināšanu Bāze
          </button>
          <button
            @click="activeTab = 'categories'"
            :class="[
              'py-4 px-1 border-b-2 font-medium text-sm',
              activeTab === 'categories'
                ? 'border-primary-500 text-primary-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
          >
            Kategorijas
          </button>
        </nav>
      </div>

      <!-- Tab Content -->
      <div class="py-8">
        <PromptEditor v-if="activeTab === 'prompt'" />
        <GuidelinesManager v-if="activeTab === 'guidelines'" />
        <KnowledgeBaseManager v-if="activeTab === 'knowledge'" />
        <CategoriesManager v-if="activeTab === 'categories'" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import PromptEditor from '../../Components/Admin/PromptEditor.vue';
import GuidelinesManager from '../../Components/Admin/GuidelinesManager.vue';
import KnowledgeBaseManager from '../../Components/Admin/KnowledgeBaseManager.vue';
import CategoriesManager from '../../Components/Admin/CategoriesManager.vue';

const activeTab = ref('prompt');
</script>

