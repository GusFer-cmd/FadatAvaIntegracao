<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    courses: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: '',
    semester: '',
    course_id: '',
});

const submit = () => {
    form.post(route('subject.store'));
};
</script>

<template>
    <Head title="Subject Register" />

    <AuthenticatedLayout>
        <template #header>
                <div class="flex items-baseline justify-between mb-6">
                    <h1 class="text-3xl font-semibold">Cadastrar Disciplina</h1>
                    <Link
                        :href="route('subject.index')"
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
                            <InputLabel for="name" value="Nome da Disciplina" class="text-white" />
                            
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.semester" />
                        </div>

                        <div>
                            <InputLabel for="semester" value="Semestre" class="text-white" />
                            
                            <TextInput
                                id="semester"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.semester"
                                autofocus
                                autocomplete="semester"
                            />

                            <InputError class="mt-2" :message="form.errors.semester" />
                        </div>

                        <div>
                            <InputLabel for="course_id" value="Curso" class="text-white" />
                            
                            <select
                                id="course_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.course_id"
                            >
                                <option value="" disabled>Selecione um curso</option>
                                <option v-for="course in props.courses" :key="course.id" :value="course.id">
                                    {{ course.name }}
                                </option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.course_id" />
                        </div>

                        <div class="flex justify-end">
                            <PrimaryButton
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Salvar
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>