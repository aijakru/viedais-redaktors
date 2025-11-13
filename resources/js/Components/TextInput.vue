<template>
  <div class="card">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">1. Teksta Ievietošana</h2>
    
    <textarea
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="textarea min-h-[400px] font-mono text-sm"
      placeholder="Iekopējiet savu tekstu šeit..."
    ></textarea>

    <!-- Character Counter -->
    <div class="mt-3 flex justify-between text-sm text-gray-600">
      <span>{{ characterCount }} rakstzīmes</span>
      <span>{{ wordCount }} vārdi</span>
    </div>

    <!-- Quick Actions -->
    <div class="mt-3 flex gap-2">
      <button
        @click="clearText"
        class="btn btn-secondary text-sm"
      >
        Notīrīt
      </button>
      <button
        @click="pasteFromClipboard"
        class="btn btn-secondary text-sm"
      >
        Ielīmēt no starpliktuves
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['update:modelValue']);

const characterCount = computed(() => {
  return props.modelValue.length;
});

const wordCount = computed(() => {
  if (!props.modelValue.trim()) return 0;
  return props.modelValue.trim().split(/\s+/).length;
});

const clearText = () => {
  if (confirm('Vai tiešām vēlaties notīrīt tekstu?')) {
    emit('update:modelValue', '');
  }
};

const pasteFromClipboard = async () => {
  try {
    const text = await navigator.clipboard.readText();
    emit('update:modelValue', text);
  } catch (error) {
    console.error('Failed to read clipboard:', error);
    alert('Neizdevās nolasīt starpliktuvi. Lūdzu, izmantojiet Ctrl+V vai Cmd+V.');
  }
};
</script>

