<template>
  <form @submit.prevent="onSubmit" class="bg-white rounded-lg p-6 shadow max-w-xl mx-auto space-y-4">
    <h2 class="text-xl font-semibold mb-4">
      <template v-if="viewOnly">Todo Details</template>
      <template v-else>{{ editing ? 'Edit Todo' : 'Add a Todo' }}</template>
    </h2>
    <div>
      <label class="block mb-1 font-medium">Title</label>
      <input v-model="form.title" required placeholder="Title"
             class="border rounded px-3 py-2 w-full"
             :readonly="viewOnly"/>
    </div>
    <div>
      <label class="block mb-1 font-medium">Description</label>
      <textarea v-model="form.description" placeholder="Description"
                class="border rounded px-3 py-2 w-full"
                :readonly="viewOnly"></textarea>
    </div>
    <div>
      <label class="block mb-1 font-medium">Due Date</label>
      <input v-model="form.due_date" type="date" required
             class="border rounded px-3 py-2 w-full"
             :readonly="viewOnly"/>
    </div>
    <div>
      <label class="block mb-1 font-medium">Status</label>
      <select v-model="form.status" class="border rounded px-3 py-2 w-full" :disabled="viewOnly">
        <option value="offen">Offen</option>
        <option value="erledigt">Erledigt</option>
      </select>
    </div>
    <div>
      <label class="block mb-1 font-medium">Category</label>
      <select v-model="form.category_type" @change="setCategoryFields"
              class="border rounded px-3 py-2 w-full" :disabled="viewOnly">
        <option value="WorkTask">Work</option>
        <option value="PersonalTask">Personal</option>
        <option value="ShoppingTask">Shopping</option>
      </select>
    </div>
    <div v-if="form.category_type === 'WorkTask'">
      <label class="block mb-1 font-medium">Priority</label>
      <input v-model="form.extra_data.priority" placeholder="Priority"
             class="border rounded px-3 py-2 w-full"
             :readonly="viewOnly"/>
    </div>
    <div v-if="form.category_type === 'PersonalTask'">
      <label class="block mb-1 font-medium">Mood</label>
      <input v-model="form.extra_data.mood" placeholder="Mood"
             class="border rounded px-3 py-2 w-full"
             :readonly="viewOnly"/>
    </div>
    <div v-if="form.category_type === 'ShoppingTask'">
      <label class="block mb-1 font-medium">Estimated Costs</label>
      <input v-model="form.extra_data.estimated_costs" placeholder="Estimated Costs" type="number"
             class="border rounded px-3 py-2 w-full"
             :readonly="viewOnly"/>
    </div>
    <div class="text-right space-x-2">
      <button v-if="!viewOnly && editing" type="button"
              class="bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded"
              @click="emit('cancel')">Cancel</button>
      <button v-if="!viewOnly" type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
        {{ editing ? 'Update' : 'Save' }}
      </button>
      <button v-if="viewOnly" type="button" @click="emit('cancel')"
              class="bg-blue-500 text-white px-4 py-2 rounded">Close</button>
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { watch, ref } from 'vue'

const props = defineProps({
  todo: Object,
  viewOnly: Boolean
})
const emit = defineEmits(['saved', 'cancel'])
const editing = ref(false)

const form = useForm({
  title: '', description: '', due_date: '', status: 'offen', category_type: 'WorkTask', extra_data: {}
})

function resetFormFields() {
  editing.value = false
  form.title = ''
  form.description = ''
  form.due_date = ''
  form.status = 'offen'
  form.category_type = 'WorkTask'
  form.extra_data = {}
}

// Watch for edit/view mode, but do NOT emit 'cancel' here!
watch(
  () => props.todo,
  (todo) => {
    if (todo) {
      editing.value = !props.viewOnly
      form.title = todo.title
      form.description = todo.description
      form.due_date = todo.due_date?.split('T')[0] ?? ''
      form.status = todo.status
      form.category_type = todo.category_type
      form.extra_data = { ...todo.extra_data }
    } else {
      resetFormFields()
    }
  },
  { immediate: true }
)

function onSubmit() {
  if (props.viewOnly) return
  if (editing.value && props.todo) {
    form.put(route('todos.update', props.todo.id), {
      onSuccess: () => { emit('saved'); resetFormFields(); }
    })
  } else {
    form.post(route('todos.store'), {
      onSuccess: () => { emit('saved'); resetFormFields(); }
    })
  }
}
function setCategoryFields() {
  if (form.category_type === 'WorkTask') form.extra_data = { priority: '' }
  else if (form.category_type === 'PersonalTask') form.extra_data = { mood: '' }
  else if (form.category_type === 'ShoppingTask') form.extra_data = { estimated_costs: 0 }
}
</script>
