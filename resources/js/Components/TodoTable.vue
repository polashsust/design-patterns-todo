<script setup>
defineProps({
  todos: { type: Object, required: true },
  sortBy: String,
  sortDir: String,
});
const emit = defineEmits(['edit', 'view', 'delete', 'sort']);
</script>

<template>
  <div class="overflow-x-auto shadow rounded-lg border border-gray-200 bg-white/95">
    <table class="w-full table-auto border-collapse">
      <thead>
        <tr class="bg-blue-100 border-b text-blue-900">
          <th
            class="py-3 px-4 font-bold cursor-pointer w-14 border-r border-blue-200 text-center select-none"
            @click="$emit('sort', 'id')"
            title="Sort by ID"
          >
            #
            <span v-if="sortBy === 'id'">
              <span v-if="sortDir === 'asc'">&#9650;</span>
              <span v-else>&#9660;</span>
            </span>
          </th>
          <th class="py-3 px-4 font-bold border-r border-blue-100">Title</th>
          <th class="py-3 px-4 font-bold border-r border-blue-100">Status</th>
          <th class="py-3 px-4 font-bold border-r border-blue-100">Category</th>
          <th class="py-3 px-4 font-bold border-r border-blue-100">Due Date</th>
          <th class="py-3 px-4 font-bold">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(todo, idx) in todos.data"
          :key="todo.id"
          :class="idx % 2 === 0 ? 'bg-white' : 'bg-blue-50 border-t'"
        >
          <td class="py-2 px-4 border-r border-blue-100 text-center font-semibold">
            {{ todo.id }}
          </td>
          <td class="py-2 px-4 border-r border-blue-100">{{ todo.title }}</td>
          <td class="py-2 px-4 border-r border-blue-100 capitalize">
            <span
              :class="{
                'bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold': todo.status === 'erledigt',
                'bg-yellow-100 text-yellow-900 px-2 py-1 rounded text-xs font-semibold': todo.status !== 'erledigt'
              }"
            >{{ todo.status }}</span>
          </td>
          <!-- Category BADGE -->
          <td class="py-2 px-4 border-r border-blue-100">
            <span
              :class="[
                'inline-block px-3 py-1 rounded-full text-xs font-semibold shadow border',
                todo.category_type === 'WorkTask' ? 'bg-blue-100 text-blue-700 border-blue-200' : '',
                todo.category_type === 'PersonalTask' ? 'bg-green-100 text-green-700 border-green-200' : '',
                todo.category_type === 'ShoppingTask' ? 'bg-pink-100 text-pink-700 border-pink-200' : ''
              ]"
            >
              {{ todo.category_type === 'WorkTask' ? 'Work'
                : todo.category_type === 'PersonalTask' ? 'Personal'
                : todo.category_type === 'ShoppingTask' ? 'Shopping'
                : todo.category_type }}
            </span>
          </td>
          <td class="py-2 px-4 border-r border-blue-100">{{ todo.due_date?.split('T')[0] }}</td>
          <td class="py-2 px-4 space-x-2 text-center">
            <button @click="$emit('view', todo)"
              class="inline-flex items-center justify-center bg-blue-50 hover:bg-blue-200 text-blue-800 font-bold px-2 py-1 rounded shadow transition"
              title="View">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              View
            </button>
            <button @click="$emit('edit', todo)"
              class="inline-flex items-center justify-center bg-yellow-200 hover:bg-yellow-300 text-yellow-900 font-bold px-2 py-1 rounded shadow transition"
              title="Edit">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1-1v2m9 5a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              Edit
            </button>
            <button @click="$emit('delete', todo.id)"
              class="inline-flex items-center justify-center bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 rounded shadow transition"
              title="Delete">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
              Del
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
