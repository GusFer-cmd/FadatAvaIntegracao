<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import { BookOpen, Users, ClipboardList, Building, CalendarDays, School } from 'lucide-vue-next';

const { props } = usePage();
const user = props.auth.user;

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white dark:text-white mb-8">
                    Guia de Uso do Sistema
                </h1>
                <div v-if="user.access_level >= 20">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        <div class="relative bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 flex flex-col items-center text-center hover:scale-105 transition-transform">
                            <span class="absolute top-4 left-4 bg-blue-500 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                                1ª
                            </span>
                            <BookOpen class="w-12 h-12 text-blue-500 mb-4" />
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Criar Curso</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                Cadastre os cursos disponíveis para associar aos agendamentos.
                            </p>
                        </div>

                        <div class="relative bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 flex flex-col items-center text-center hover:scale-105 transition-transform">
                            <span class="absolute top-4 left-4 bg-green-500 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                                2ª
                            </span>
                            <Users class="w-12 h-12 text-green-500 mb-4" />
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Criar Professor</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                Cadastre os professores que ministrarão as disciplinas.
                            </p>
                        </div>
                        
                        <div class="relative bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 flex flex-col items-center text-center hover:scale-105 transition-transform">
                            <span class="absolute top-4 left-4 bg-purple-500 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                                3ª
                            </span>
                            <ClipboardList class="w-12 h-12 text-purple-500 mb-4" />
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Criar Disciplina</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                Defina as disciplinas que serão oferecidas nos cursos.
                            </p>
                        </div>

                        <div class="relative bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 flex flex-col items-center text-center hover:scale-105 transition-transform">
                            <span class="absolute top-4 left-4 bg-orange-500 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                                4ª
                            </span>
                            <Building class="w-12 h-12 text-orange-500 mb-4" />
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Criar Sala</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                Cadastre as salas disponíveis para agendamento.
                            </p>
                        </div>

                        <div class="relative bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 flex flex-col items-center text-center hover:scale-105 transition-transform sm:col-span-2 lg:col-span-1">
                            <span class="absolute top-4 left-4 bg-red-500 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                                5ª
                            </span>
                            <CalendarDays class="w-12 h-12 text-red-500 mb-4" />
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Criar Agendamento</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                Combine curso, professor, disciplina e sala para criar o agendamento final.
                            </p>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="relative bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 flex flex-col items-center text-center hover:scale-105 transition-transform">
                            <span class="absolute top-4 left-4 bg-blue-500 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                                1ª
                            </span>
                            <School class="w-12 h-12 text-blue-500 mb-4" />
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Encontrando Sala</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                Descubra onde acontecerá sua aula em 
                                <span class="font-bold">
                                    <Link :href="route('roomboking.index')">
                                        "Agendamentos de sala".
                                    </Link>
                                </span>
                            </p>
                        </div>
                    </div>         
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
