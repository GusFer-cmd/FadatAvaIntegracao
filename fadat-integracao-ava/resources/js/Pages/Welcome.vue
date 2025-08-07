<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-[#113F67] text-black/50 dark:bg-black dark:text-white/50 min-h-screen">
        <nav class="fixed top-0 left-0 w-full z-50 bg-gray-50 dark:bg-black shadow h-14 flex items-center">
            <div class="max-w-7xl mx-auto w-full flex items-center justify-between px-6">
                <div class="flex items-center px-4">
                    <img
                        src="/images/logo.png"
                        alt="Logo FADAT"
                        class="h-8 w-auto sm:h-10 md:h-12"
                        style="max-width:120px"
                    />
                </div>
                <div class="flex gap-2">
                    <Link
                        :href="route('login')"
                        class="rounded-md px-3 py-1 text-black dark:text-white hover:bg-gray-200 dark:hover:bg-gray-900 transition"
                    >
                        Logar
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-md px-3 py-1 text-black dark:text-white hover:bg-gray-200 dark:hover:bg-gray-900 transition"
                    >
                        Registrar
                    </Link>
                </div>
            </div>
        </nav>

        <div class="h-14"></div>

        <main class="flex justify-center items-center min-h-[calc(100vh-56px)] px-4">
            <div class="block w-full max-w-lg md:max-w-2xl p-6 md:p-10 bg-white border border-gray-200 rounded-2xl shadow-2xl">
                <h5 class="mb-2 text-xl md:text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                    Bem-vindo ao FADAT INTEGRAÇÃO
                </h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">
                    Esta é uma aplicação de integração da FADAT para com os processos do AVA.
                </p>
                <p class="mt-4 text-xs md:text-sm text-gray-500 dark:text-gray-400">
                    Laravel Version: {{ laravelVersion }}<br />
                    PHP Version: {{ phpVersion }}
                </p>
            </div>
        </main>
    </div>
</template>
