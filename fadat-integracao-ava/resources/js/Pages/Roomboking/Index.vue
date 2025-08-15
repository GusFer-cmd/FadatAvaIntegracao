<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head, Link } from '@inertiajs/vue3';

const editRoomboking = (roomboking) => { 
    const encodedId = btoa(roomboking.id);
    router.get(route('roomboking.edit', encodedId));
};

const removeRoomboking = (roomboking) => {
    if (confirm(`Deseja realmente deletar a sala "${roomboking.class_number}"?`)) {
        router.delete(route('roomboking.delete', roomboking.id));
    }
};
</script>

<template>
    <Head title="Roombooking Index"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-baseline justify-between mb-2">
                        <h1 class="text-3xl font-semibold mb-6">Agendamentos de Salas</h1>
                        <Link
                            :href="route('roomboking.create')"
                            class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Criar Agendamento
                        </Link>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div v-for="roomboking in roombokings" :key="roomboking.id" class="bg-[#E9E9E9] rounded-lg shadow p-5 flex flex-col justify-between dark:bg-gray-700">
                            <h2 class="text-xl font-medium text-gray-800 dark:text-gray-100 truncate">Sala: {{ roomboking.class_number }}</h2>
                            <span class="text-md text-gray-700 dark:text-gray-300">Data: {{ roomboking.start_date_time }}</span>
                            
                            <div class="mt-4 flex space-x-3 justify-end">
                                <button
                                    @click="editRoomboking(roomboking)"
                                    class="text-blue-600 hover:text-blue-800 transition"
                                    aria-label="Editar agendamento"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l2.121 2.121a2.828 2.828 0 010 4l-8.485 8.485a2.828 2.828 0 01-4 0l-2.121-2.121a2.828 2.828 0 010-4l8.485-8.485a2.828 2.828 0 014 0zM18.364 6.879l1.414 1.414m0 0L19.778 9m1.414-1.414L19.778 9m0 0L16.95 11.829m-.707-.707L14.12 13m-.707-.707L11.293 15m-.707-.707L8.465 17m-.707-.707L5.636 19m-.707-.707L3.464 21"></path>
                                    </svg>
                                </button>
                                <button
                                    @click="removeRoomboking(roomboking)"
                                    class="text-red-600 hover:text-red-800 transition"
                                    aria-label="Deletar agendamento"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-2 14H7L5 7m14-4h-3.586a1 1 0 00-.707.293l-1.414 1.414a1 1 0 01-.707.293H8a1 1 0 00-1 1v2h10V4a1 1 0 00-1-1z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6m4-6v6m-2-10h2m-2 0H8m0 0a1 1 0 011-1h6a1 1 0 011 1m-8 0a1 1 0 001-1"></path>
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