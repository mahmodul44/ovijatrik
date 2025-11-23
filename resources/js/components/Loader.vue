<template>
  <transition name="fade">
    <div
      v-if="show"
      class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-80 backdrop-blur-sm"
    >
      <div class="flex flex-col items-center space-y-4">
        <!-- Spinner -->
        <div class="w-16 h-16 border-4 border-green-500 border-t-transparent rounded-full animate-spin"></div>
        <p class="text-green-700 font-medium text-lg">Loading...</p>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, watch } from 'vue'

const show = ref(true)

setTimeout(() => {
  show.value = false
}, 1500)
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
