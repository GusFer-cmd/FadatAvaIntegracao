<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head, Link } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps({
    roombookings: {
        type: Array,
        default: () => [],
    },
    courses: {
        type: Array,
        default: () => [],
    },
});

function getCourseName(courseId) {
    const course = props.courses.find(course => course.id === courseId);
    return course ? course.name : 'Curso não encontrado';
}

const searchTerm = ref('');

watch(searchTerm, (newTerm) => {
    router.get(route('roomboking.search'), { search: newTerm }, { preserveState: true, replace: true });
});

const editRoomboking = (roombooking) => { 
    const encodedId = btoa(roombooking.id);
    router.get(route('roomboking.edit', encodedId));
};

const removeRoomboking = (roombooking) => {
    if (confirm('Deseja realmente deletar o agendamento da sala?')) {
        router.delete(route('roomboking.delete', roombooking.id));
    }
};

const formatDateBR = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>

<template>
    <Head title="Roombooking Index" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl sm:text-3xl font-semibold">Agendamentos de Salas</h1>
                        
                        <input
                            type="text"
                            v-model="searchTerm"
                            placeholder="Nome do Professor, Curso ou Disciplina..."
                            class="w-full sm:w-80 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100"
                        />

                        <Link
                            :href="route('roomboking.create')"
                            class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Criar Agendamento
                        </Link>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 dark:bg-gray-700 hidden sm:table-header-group">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Sala</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Data</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Curso</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Disciplina</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Professor</th>
                                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="block sm:table-row-group">
                                <tr
                                    v-for="roombooking in roombookings"
                                    :key="roombooking.id"
                                    class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition block sm:table-row mb-4 sm:mb-0"
                                >
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium block sm:table-cell">
                                        <span class="font-semibold sm:hidden">Sala: </span>
                                        {{ roombooking.classroom
                                            ? (roombooking.classroom.academic_building
                                                ? `${roombooking.classroom.class_number} - Bloco: (${roombooking.classroom.academic_building})`
                                                : `${roombooking.classroom.class_number} - Sala Virtual`)
                                            : 'Sala não encontrada' }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 block sm:table-cell">
                                        <span class="font-semibold sm:hidden">Data: </span>
                                        {{ formatDateBR(roombooking.start_date_time) }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 block sm:table-cell">
                                        <span class="font-semibold sm:hidden">Curso: </span>
                                        {{ getCourseName(roombooking.subject.course_id) ?? 'Curso não encontrado' }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 block sm:table-cell">
                                        <span class="font-semibold sm:hidden">Disciplina: </span>
                                        {{ roombooking.subject?.name ?? 'Disciplina não encontrada' }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 block sm:table-cell">
                                        <span class="font-semibold sm:hidden">Professor: </span>
                                        {{ roombooking.professor?.name ?? 'Professor não encontrado' }}
                                    </td>

                                    <td class="px-6 py-4 text-right space-x-3 flex justify-end sm:table-cell">
                                        <button
                                            @click="editRoomboking(roombooking)"
                                            class="text-blue-600 hover:text-blue-800 transition"
                                            aria-label="Editar agendamento"
                                        >
                                            <Pencil class="w-5 h-5" />
                                        </button>
                                        <button
                                            @click="removeRoomboking(roombooking)"
                                            class="text-red-600 hover:text-red-800 transition"
                                            aria-label="Deletar agendamento"
                                        >
                                            <Trash2 class="w-5 h-5" />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
