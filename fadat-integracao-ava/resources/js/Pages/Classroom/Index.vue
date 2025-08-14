<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head, Link } from '@inertiajs/vue3';

defineProps({
    classrooms: {
        type: Array,
        default: () => [],
    },
});

const editClassroom = (classroom) => { 
    const encodedId = btoa(classroom.id);
    router.get(route('classroom.edit', encodedId));
};

const removeClassroom = (classroom) => {
    if (confirm(`Deseja realmente deletar a sala "${classroom.class_number}"?`)) {
        router.delete(route('classroom.delete', classroom.id));
    }
};

</script>

<template>
    <Head title="Classroom Index"/>

    <AuthenticatedLayout>
     <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-baseline justify-between mb-2">
                        <h1 class="text-3xl font-semibold mb-6">Salas</h1>
                        <Link
                            :href="route('classroom.create')"
                            class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Criar Sala
                        </Link>
                    </div>
                
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div v-for="classroom in classrooms" :key="classroom.id" class="bg-[#E9E9E9] rounded-lg shadow p-5 flex flex-col justify-between dark:bg-gray-700">
                            <div v-if="classroom.academic_building">
                                <h2 class="text-xl font-medium text-gray-800 dark:text-gray-100 truncate">Bloco: {{ classroom.academic_building || 'Sem indentificação' }} <span>- Sala {{ classroom.class_number }}</span></h2>
                            </div>
                            <div v-else>
                                <h2 class="text-xl font-medium text-gray-800 dark:text-gray-100 truncate">Bloco: {{ classroom.academic_building || 'Sala Virtual' }}</h2>
                                <span class="text-md text-gray-700 dark:text-gray-300">Link da sala: {{ classroom.url }}</span>
                            </div>
                            
                            <div class="mt-4 flex space-x-3 justify-end">
                                <button
                                    @click="editClassroom(classroom)"
                                    class="text-blue-600 hover:text-blue-800 transition"
                                    aria-label="Editar sala"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536M9 11l6-6m-6 6L5 19a2 2 0 002 2l6-6" />
                                    </svg>
                                </button>
                                
                                <button
                                    @click="removeClassroom(classroom)"
                                    class="text-red-600 hover:text-red-800 transition"
                                    aria-label="Remover sala"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>