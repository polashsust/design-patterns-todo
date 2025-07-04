<template>
  <transition name="fade">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
      <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-bold text-red-600 mb-4">Are you sure you want to delete this todo?</h2>
        <div class="flex justify-end gap-4 mt-6">
          <button @click="$emit('cancel')"
                  class="px-4 py-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-100">
            No, Cancel
          </button>
          <button @click="$emit('confirm')"
                  class="px-4 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-700">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
defineProps({ show: Boolean })
defineEmits(['confirm', 'cancel'])
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
