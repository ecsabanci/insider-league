<script setup lang="ts">
defineProps<{
  loading: boolean
}>()

const emit = defineEmits<{
  generate: []
  playWeek: []
  playAll: []
  reset: []
}>()
</script>

<template>
  <div class="controls">
    <button :disabled="loading" @click="emit('generate')">Generate Fixtures</button>
    <button :disabled="loading" @click="emit('playWeek')">Play Next Week</button>
    <button :disabled="loading" @click="emit('playAll')">Play All</button>
    <button :disabled="loading" @click="emit('reset')">Reset</button>
  </div>
</template>