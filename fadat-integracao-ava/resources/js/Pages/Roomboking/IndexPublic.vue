<script setup>
import { router, Head, Link, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
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
    router.get(route('roomboking.search.public'), { search: newTerm }, { preserveState: true, replace: true });
});

const formatHour = (time) => {
    return time ? time.split(':').slice(0, 2).join(':') : '';
};
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-[#113F67] text-black/50 dark:bg-black dark:text-white/50 min-h-screen">
        <div class="h-14"></div>

        <main class="flex justify-center items-center min-h-[calc(100vh-56px)] px-4">
            <div class="flex flex-col">
                <div class="flex justify-center ">
                    <img src="/images/logoFADAT.png" alt="Logo FADAT" style="max-width:420px;" />
                </div>
                <div class="py-12">
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                                <h1 class="text-2xl sm:text-3xl font-semibold">Locação de Salas</h1>
                                
                                <div class="flex flex-col sm:flex-row sm:items-center gap-4 w-full sm:w-auto">
                                    <input
                                        type="text"
                                        v-model="searchTerm"
                                        placeholder="Nome do Professor, Curso ou Disciplina..."
                                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100 w-full sm:w-80"
                                    />
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                                    <thead class="bg-gray-100 dark:bg-gray-700 hidden sm:table-header-group">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Sala</th>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Horário</th>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Curso</th>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Disciplina</th>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Professor</th>
                                        </tr>
                                    </thead>
                                    <tbody class="block sm:table-row-group">
                                        <tr
                                            v-for="roombooking in roombookings"
                                            :key="roombooking.id"
                                            class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition block sm:table-row mb-4 sm:mb-0"
                                        >
                                            <td class="px-4 sm:px-6 py-3 text-gray-900 dark:text-gray-100 font-medium block sm:table-cell">
                                                <span class="font-semibold sm:hidden">Sala: </span>
                                                {{ roombooking.classroom
                                                    ? (roombooking.classroom.academic_building
                                                        ? `Bloco: ${roombooking.classroom.academic_building} - (Sala ${roombooking.classroom.class_number})`
                                                        : `Virtual - (Sala ${roombooking.classroom.class_number})`)
                                                    : 'Sala não encontrada' }}
                                            </td>

                                            <td class="px-4 sm:px-6 py-3 text-gray-700 dark:text-gray-300 block sm:table-cell">
                                                <span class="font-semibold sm:hidden">Horário: </span>
                                                {{ formatHour(roombooking.start_time) }} - {{ formatHour(roombooking.end_time) }}
                                            </td>

                                            <td class="px-4 sm:px-6 py-3 text-gray-700 dark:text-gray-300 block sm:table-cell">
                                                <span class="font-semibold sm:hidden">Curso: </span>
                                                {{ getCourseName(roombooking.subject.course_id) ?? 'Curso não encontrado' }}
                                            </td>

                                            <td class="px-4 sm:px-6 py-3 text-gray-700 dark:text-gray-300 block sm:table-cell">
                                                <span class="font-semibold sm:hidden">Disciplina: </span>
                                                {{ roombooking.subject?.name ?? 'Disciplina não encontrada' }}
                                            </td>

                                            <td class="px-4 sm:px-6 py-3 text-gray-700 dark:text-gray-300 block sm:table-cell">
                                                <span class="font-semibold sm:hidden">Professor: </span>
                                                {{ roombooking.professor?.name ?? 'Professor não encontrado' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
