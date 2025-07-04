<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref, reactive } from 'vue'

import TodoForm from '@/Components/TodoForm.vue'
import TodoTable from '@/Components/TodoTable.vue'
import TodoPagination from '@/Components/TodoPagination.vue'
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue'

// 🧾 Props from backend
const props = defineProps({
  todos: Object,
  filters: Object,
  sort_by: String,
  sort_dir: String,
})

// 📦 State
const filter = reactive({ category: props.filters.category ?? '' })
const selectedTodo = ref(null)
const showForm = ref(false)
const viewOnly = ref(false)
const sortBy = ref(props.sort_by || 'id')
const sortDir = ref(props.sort_dir || 'desc')
const confirmDeleteId = ref(null)

// 🎛️ UI Methods
const openAddForm = () => { selectedTodo.value = null; viewOnly.value = false; showForm.value = true }
const editTodo = (todo) => { selectedTodo.value = { ...todo }; viewOnly.value = false; showForm.value = true }
const viewTodo = (todo) => { selectedTodo.value = { ...todo }; viewOnly.value = true; showForm.value = true }
const onFormSaved = () => { showForm.value = false; selectedTodo.value = null; reloadTodos() }

// ✨ Show delete modal
function askDelete(id) {
  confirmDeleteId.value = id
}

function confirmDelete() {
  if (!confirmDeleteId.value) return
  router.delete(route('todos.destroy', confirmDeleteId.value), {
    onSuccess: () => {
      confirmDeleteId.value = null
      reloadTodos()
    }
  })
}

// 📤 CSV Download
const downloadCSV = () => {
  const rows = [
    ['ID', 'Title', 'Status', 'Category', 'Due Date'],
    ...props.todos.data.map(todo => [
      todo.id, todo.title, todo.status, todo.category_type, todo.due_date
    ])
  ]
  const csv = "data:text/csv;charset=utf-8," + rows.map(e => e.join(",")).join("\n")
  const link = document.createElement("a")
  link.setAttribute("href", encodeURI(csv))
  link.setAttribute("download", "todos.csv")
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}

// 🔃 Sorting, Filtering, Paging
const applyFilter = () => {
  router.get(route('todos.index'), {
    category: filter.category,
    sort_by: sortBy.value,
    sort_dir: sortDir.value
  }, { preserveState: true })
}

const goToPage = (page) => {
  router.get(route('todos.index'), {
    ...filter,
    sort_by: sortBy.value,
    sort_dir: sortDir.value,
    page
  }, { preserveState: true })
}

function reloadTodos() {
  router.get(route('todos.index'), {
    ...filter,
    sort_by: sortBy.value,
    sort_dir: sortDir.value,
    page: props.todos.current_page
  }, {
    preserveState: true,
    preserveScroll: true,
    only: ['todos'],
  })
}

const setSort = (column) => {
  if (sortBy.value === column) {
    sortDir.value = sortDir.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortBy.value = column
    sortDir.value = 'desc'
  }
  applyFilter()
}
</script>

<template>
  <Head title="Todos" />

  <AuthenticatedLayout>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-12">
      <div class="max-w-5xl mx-auto">
        <div class="bg-white/90 shadow-xl rounded-2xl px-8 py-8 mb-8 border border-blue-100">
          <h1 class="text-4xl font-extrabold mb-8 text-center text-blue-900 tracking-tight drop-shadow">
            🗂️ Todos Dashboard
          </h1>

          <!-- 🔍 Filters -->
          <form @submit.prevent="applyFilter" class="mb-8 flex flex-wrap gap-4 justify-center items-center">
            <label for="filter-category" class="text-gray-700 font-medium">Category Type:</label>
            <select id="filter-category" v-model="filter.category"
              class="border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-300 text-base bg-white">
              <option value="">All</option>
              <option value="WorkTask">Work</option>
              <option value="PersonalTask">Personal</option>
              <option value="ShoppingTask">Shopping</option>
            </select>
            <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow transition">
              Apply Filter
            </button>
          </form>

          <!-- ✨ Actions -->
          <div class="flex flex-wrap gap-4 mb-8 justify-center">
            <button @click="downloadCSV"
              class="bg-blue-100 hover:bg-blue-200 text-blue-900 font-semibold px-5 py-2 rounded-lg shadow transition flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
              </svg>
              Export CSV
            </button>

            <button @click="openAddForm"
              class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded-lg shadow flex items-center gap-2 transition">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Add Todo
            </button>
          </div>

          <!-- 📋 Table -->
          <TodoTable
            :todos="props.todos"
            :sort-by="sortBy"
            :sort-dir="sortDir"
            @edit="editTodo"
            @view="viewTodo"
            @delete="askDelete"
            @sort="setSort"
          />

          <!-- 📄 Pagination -->
          <TodoPagination
            :todos="props.todos"
            @go="goToPage"
          />

          <!-- 🧾 Modal (Form) -->
          <transition name="fade">
            <div v-if="showForm" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 backdrop-blur-sm">
              <div class="bg-white rounded-2xl shadow-2xl p-8 min-w-[350px] max-w-lg w-full relative">
                <button @click="showForm = false"
                  class="absolute top-3 right-4 text-3xl text-gray-400 hover:text-gray-800 focus:outline-none">&times;</button>
                <TodoForm :todo="selectedTodo" :viewOnly="viewOnly" @saved="onFormSaved" @cancel="showForm = false" />
              </div>
            </div>
          </transition>

          <!-- ❗ Delete Modal -->
          <DeleteConfirmModal
            :show="confirmDeleteId !== null"
            @confirm="confirmDelete"
            @cancel="confirmDeleteId = null"
          />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
