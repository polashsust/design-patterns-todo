<script setup>
const props = defineProps({
  todos: Object,
})
const emit = defineEmits(['go'])

import { computed } from 'vue'

const entryInfo = computed(() => {
  if (!props.todos.data.length) return 'No entries found.'
  const perPage = props.todos.per_page
  const page = props.todos.current_page
  const total = props.todos.total
  const from = (page - 1) * perPage + 1
  const to = Math.min(page * perPage, total)
  return `Showing ${from} to ${to} of ${total} entries`
})

// Simple ellipsis logic
const pagesToShow = computed(() => {
  const current = props.todos.current_page
  const last    = props.todos.last_page
  let pages = []

  pages.push(1)
  if (current > 4) pages.push('...')
  for (let i = Math.max(2, current - 2); i <= Math.min(last - 1, current + 2); i++) {
    pages.push(i)
  }
  if (current < last - 3) pages.push('...')
  if (last > 1) pages.push(last)
  return pages
})
</script>

<template>
  <div class="flex items-center justify-between mt-8 gap-2">
    <div class="text-sm text-gray-700 px-3 py-1 rounded bg-blue-50 border border-blue-100 shadow-sm">
      {{ entryInfo }}
    </div>
    <nav class="flex items-center gap-1">
      <button
        :disabled="props.todos.current_page === 1"
        @click="$emit('go', props.todos.current_page - 1)"
        class="px-4 py-1 border rounded disabled:opacity-50 bg-white hover:bg-blue-50"
      >« Previous</button>
      <button
        v-for="page in pagesToShow"
        :key="page"
        :disabled="page === '...'"
        @click="page !== '...' && $emit('go', page)"
        :class="[
          'px-4 py-1 border rounded font-semibold',
          page === props.todos.current_page ? 'bg-blue-600 text-white border-blue-600 shadow' : 'bg-white hover:bg-blue-50',
          page === '...' ? 'cursor-default text-gray-400 border-none bg-transparent' : ''
        ]"
      >{{ page }}</button>
      <button
        :disabled="props.todos.current_page === props.todos.last_page"
        @click="$emit('go', props.todos.current_page + 1)"
        class="px-4 py-1 border rounded disabled:opacity-50 bg-white hover:bg-blue-50"
      >Next »</button>
    </nav>
  </div>
</template>
