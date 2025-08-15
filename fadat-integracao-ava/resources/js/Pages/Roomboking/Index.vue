<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head, Link } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';

const props = defineProps({
    roombookings: Array,
    professors: Array,
    subjects: Array,
    classrooms: Array,
});

const editRoomboking = (roomboking) => { 
    const encodedId = btoa(roomboking.id);
    router.get(route('roomboking.edit', encodedId));
};

const removeRoomboking = (roomboking) => {
    if (confirm(`Deseja realmente deletar a sala "${roomboking.class_number}"?`)) {
        router.delete(route('roomboking.delete', roomboking.id));
    }
};

const getClassroomName = (id) => {
    const classroom = props.classrooms.find(c => c.id === id);
    return classroom
        ? `${classroom.class_number} (${classroom.academic_building})`
        : 'Sala não encontrada';
};

const getProfessorName = (id) => {
    const professor = props.professors.find(p => p.id === id);
    return professor ? professor.name : 'Professor não encontrado';
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
                        <h1 class="text-3xl font-semibold">Agendamentos de Salas</h1>
                        <Link
                            :href="route('roomboking.create')"
                            class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Criar Agendamento
                        </Link>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Sala</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Data</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Professor</th>
                                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="roomboking in roombookings"
                                    :key="roomboking.id"
                                    class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition"
                                >
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium">
                                        {{ getClassroomName(roomboking.classroom_id) }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ formatDateBR(roomboking.start_date_time) }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ getProfessorName(roomboking.professor_id) }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3 flex justify-end">
                                        <button
                                            @click="editRoomboking(roomboking)"
                                            class="text-blue-600 hover:text-blue-800 transition"
                                            aria-label="Editar agendamento"
                                        >
                                            <Pencil class="w-5 h-5" />
                                        </button>
                                        <button
                                            @click="removeRoomboking(roomboking)"
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
