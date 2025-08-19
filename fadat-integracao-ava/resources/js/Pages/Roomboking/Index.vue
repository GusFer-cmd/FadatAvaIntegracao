<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head, Link, usePage } from '@inertiajs/vue3';
import { ArrowLeft, ArrowRight, Pencil, Trash2 } from 'lucide-vue-next';
import { ref, watch, computed } from 'vue';

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

const user = usePage().props.auth.user;

function getCourseName(courseId) {
    const course = props.courses.find(course => course.id === courseId);
    return course ? course.name : 'Curso não encontrado';
}

const searchTerm = ref('');

const filteredBookings = computed(() => {
    if (!searchTerm.value || searchTerm.value.length < 3) {
        return props.roombookings;
    }

    const term = searchTerm.value.toLowerCase();

    return props.roombookings.filter(rb => {
        const professorName = rb.professor?.name?.toLowerCase() || '';
        const subjectName = rb.subject?.name?.toLowerCase() || '';
        const courseName = getCourseName(rb.subject?.course_id)?.toLowerCase() || '';

        return professorName.includes(term) || subjectName.includes(term) || courseName.includes(term);
    });
});

const editRoomboking = (roombooking) => { 
    const encodedId = btoa(roombooking.id);
    router.get(route('roomboking.edit', { encodedId }));
};

const removeRoomboking = (roombooking) => {
    console.log(roombooking)
    if (confirm(`Deseja realmente deletar o agendamento da sala "${roombooking.id}"?`)) {
        router.delete(route('roomboking.delete', roombooking.id));
    }
};

const formatHour = (time) => {
    return time ? time.split(':').slice(0, 2).join(':') : '';
};

// Configuração da paginação
const currentPage = ref(1);
const perPage = ref(15);

const totalPages = computed(() => Math.ceil(filteredBookings.value.length / perPage.value));

const paginatedBookings = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    return filteredBookings.value.slice(start, start + perPage.value);
});

watch(searchTerm, () => {
    currentPage.value = 1;
});

function changePage(page) {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
}
</script>

<template>
    <Head title="Roombooking Index" />

    <AuthenticatedLayout>
        <div class="flex justify-center mt-8">
            <img src="/images/logoFADAT.png" alt="Logo FADAT" class="max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl w-full h-auto" />
        </div>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                        <h1 class="text-2xl sm:text-3xl font-semibold">Agendamentos de Salas</h1>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 w-full sm:w-auto">
                            <input
                                type="text"
                                v-model="searchTerm"
                                placeholder="Nome do Professor, Curso ou Disciplina..."
                                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100 w-full sm:w-80"
                            />

                            <Link
                                :href="route('roomboking.create')"
                                class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto text-center"
                            >
                                Criar Agendamento
                            </Link>
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
                                    <th v-if="user.access_level >=80" class="px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="block sm:table-row-group">
                                <tr
                                    v-for="roombooking in paginatedBookings"
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

                                    <td v-if="user.access_level >=80" class="px-4 sm:px-6 py-3 text-right space-x-3 flex justify-end sm:table-cell">
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

                    <div class="flex justify-center items-center gap-2 mt-6">
                        <button 
                            @click="changePage(currentPage - 1)" 
                            :disabled="currentPage === 1"
                            class="px-3 py-1 rounded-lg border disabled:opacity-50"
                        >
                            <ArrowLeft class="w-4 h-4" />
                        </button>
                                
                        <button
                            v-for="page in totalPages"
                            :key="page"
                            @click="changePage(page)"
                            :class="[
                                'px-3 py-1 rounded-lg border',
                                currentPage === page ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-700'
                            ]"
                            >
                                {{ page }}
                        </button>

                        <button 
                            @click="changePage(currentPage + 1)" 
                            :disabled="currentPage === totalPages"
                            class="px-3 py-1 rounded-lg border disabled:opacity-50"
                        >
                            <ArrowRight class="w-4 h-4" />
                        </button>
                    </div>
                                
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
