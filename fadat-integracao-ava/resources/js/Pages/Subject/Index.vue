<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head, Link } from '@inertiajs/vue3';
import { Pencil, Trash2, ArrowLeft, ArrowRight} from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps({
    subjects: {
        type: Array,
        default: () => [],
    },
});

const currentPage = ref(1);
const perPage = 15;

const paginatedSubjects = computed(() => {
    const start = (currentPage.value - 1) * perPage;
    const end = start + perPage;
    return props.subjects.slice(start, end);
});

const totalPages = computed(() => Math.ceil(props.subjects.length / perPage));

const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
};

const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};

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
                        <div v-for="subject in paginatedSubjects" :key="subject.id" class="bg-[#E9E9E9] rounded-lg shadow p-5 flex flex-col justify-between dark:bg-gray-700">
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

            <div class="mt-6 flex justify-center space-x-4">
                <button
                    @click="prevPage"
                    :disabled="currentPage === 1"
                    class="px-4 py-2 bg-yellow-400 rounded"
                >
                    <ArrowLeft class="w-4 h-4" />
                </button>

                <span class="px-2 py-1 text-white">{{ currentPage }} / {{ totalPages }}</span>

                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class="px-4 py-2 bg-yellow-400 rounded"
                >
                    <ArrowRight class="w-4 h-4" />
                </button>
            </div>

        </div>
    </AuthenticatedLayout>
</template>