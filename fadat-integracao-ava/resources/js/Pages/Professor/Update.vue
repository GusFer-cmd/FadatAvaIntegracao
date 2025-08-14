<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    professor: {
        type: Object,
        required: true
    },
});

const form = useForm({
    name: props.professor.name || 'Curso não encontrado',
});

const submit = () => {
    form.put(route('professor.update', props.professor.id));
};
</script>

<template>
    <Head title="Professor Update" />

    <AuthenticatedLayout>
        <template #header>
                <div class="flex items-baseline justify-between mb-6">
                    <h1 class="text-3xl font-semibold">Atualizar Professor(a)</h1>
                    <Link
                        :href="route('professor.index')"
                        class="px-4 py-2 border border-gray-500 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        Voltar
                    </Link>
                </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="mx-4 space-y-4">
                        <div>
                            <InputLabel for="name" value="Nome" class="text-white" />
                            
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="flex justify-end">
                            <PrimaryButton
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Atualizar
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
  </AuthenticatedLayout>
</template>
