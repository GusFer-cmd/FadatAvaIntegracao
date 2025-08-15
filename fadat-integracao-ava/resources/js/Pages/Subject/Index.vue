<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head, Link } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';

defineProps({
    subjects: {
        type: Array,
        default: () => [],
    },
});

const editSubject = (subject) => { 
  const encodedId = btoa(subject.id);
  router.get(route('subject.edit', encodedId));
};

const removeSubject = (subject) => {
  if (confirm(`Deseja realmente deletar a disciplina "${subject.name}"?`)) {
    router.delete(route('subject.delete', subject.id));
  }
};

</script>

<template>
    <Head title="Subject Index" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 p-6 text-gray-900 dark:text-gray-100">
                <div class="flex items-baseline justify-between mb-2">
                  <h1 class="text-3xl font-semibold mb-6">Disciplinas</h1>
                    <Link
                      :href="route('subject.create')"
                      class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                      Criar Disciplina
                    </Link>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div v-for="subject in subjects" :key="subject.id" class="bg-[#E9E9E9] rounded-lg shadow p-5 flex flex-col justify-between dark:bg-gray-700">
                        <h2 class="text-xl font-medium text-gray-800 dark:text-gray-100 truncate">{{ subject.name || subject.title || 'Sem título' }}</h2>
                        
                        <div class="mt-4 flex space-x-3 justify-end">
                            <button
                                @click="editSubject(subject)"
                                class="text-blue-600 hover:text-blue-800 transition"
                                aria-label="Editar disciplina"
                            >
                                <Pencil class="w-5 h-5" />
                            </button>
                            
                            <button
                                @click="removeSubject(subject)"
                                class="text-red-600 hover:text-red-800 transition"
                                aria-label="Remover disciplina"
                            >
                                <Trash2 class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>