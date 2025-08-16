<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    roombooking: {
        type: Object,
        required: true
    },
    professors: {
        type: Array,
        default: () => [],
    },
    subjects: {
        type: Array,
        default: () => [],
    },
    classrooms: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    day_of_week: props.roombooking.day_of_week || '',
    start_time: props.roombooking.start_time || '',
    end_time: props.roombooking.end_time || '',
    professor_id: props.roombooking.professor_id || '',
    subject_id: props.roombooking.subject_id || '',
    classroom_id: props.roombooking.classroom_id || '',
});

const submit = () => {
    if (form.start_time.includes(':')) {
        form.start_time = form.start_time.slice(0, 5);
    }
    if (form.end_time.includes(':')) {
        form.end_time = form.end_time.slice(0, 5);
    }

    form.put(route('roomboking.update', props.roombooking.id));
};

const daysOfWeek = [
    { value: 0, label: 'Domingo' },
    { value: 1, label: 'Segunda-feira' },
    { value: 2, label: 'Terça-feira' },
    { value: 3, label: 'Quarta-feira' },
    { value: 4, label: 'Quinta-feira' },
    { value: 5, label: 'Sexta-feira' },
    { value: 6, label: 'Sábado' },
];
</script>

<template>
    <Head title="Cadastrar Agendamento de Sala" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-baseline justify-between mb-6">
                <h1 class="text-3xl font-semibold">Atualizar Agendamento de Sala</h1>
                <Link
                    :href="route('roomboking.index')"
                    class="px-4 py-2 border border-gray-500 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500"
                >
                    Voltar
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="space-y-4">
                    <div v-if="form.errors.roombooking" class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                        {{ form.errors.roombooking }}
                    </div>

                    <div class="mx-4 space-y-4">
                        <div>
                            <InputLabel for="day_of_week" value="Dia da Semana" class="text-white" />
                            <select
                                id="day_of_week"
                                v-model="form.day_of_week"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600"
                            >
                                <option value="">Selecione o dia</option>
                                <option v-for="day in daysOfWeek" :key="day.value" :value="day.value">
                                    {{ day.label }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.day_of_week" />
                        </div>

                        <div>
                            <InputLabel for="start_time" value="Horário de Início" class="text-white" />
                            <TextInput
                                id="start_time"
                                type="time"
                                class="mt-1 block w-full"
                                v-model="form.start_time"
                                autofocus
                            />
                            <InputError class="mt-2" :message="form.errors.start_time" />
                        </div>

                        <div>
                            <InputLabel for="end_time" value="Horário de Término" class="text-white" />
                            <TextInput
                                id="end_time"
                                type="time"
                                class="mt-1 block w-full"
                                v-model="form.end_time"
                            />
                            <InputError class="mt-2" :message="form.errors.end_time" />
                        </div>

                        <div>
                            <InputLabel for="professor_id" value="Professor" class="text-white" />
                            <select
                                id="professor_id"
                                v-model="form.professor_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600"
                            >
                                <option value="">Selecione um professor</option>
                                <option v-for="professor in professors" :key="professor.id" :value="professor.id">
                                    {{ professor.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.professor_id" />
                        </div>

                        <div>
                            <InputLabel for="subject_id" value="Disciplina" class="text-white" />
                            <select
                                id="subject_id"
                                v-model="form.subject_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600"
                            >
                                <option value="">Selecione uma disciplina</option>
                                <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                    {{ subject.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.subject_id" />
                        </div>

                        <div>
                            <InputLabel for="classroom_id" value="Sala" class="text-white" />
                            <select
                                id="classroom_id"
                                v-model="form.classroom_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600"
                            >
                                <option value="">Selecione uma sala</option>
                                <option 
                                    v-for="classroom in classrooms" 
                                    :key="classroom.id" 
                                    :value="classroom.id"
                                >
                                    Sala: {{ classroom.class_number }} - 
                                    {{ classroom.person_class === 'ED' ? 'Sala Virtual' : 'Bloco: ' + classroom.academic_building }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.classroom_id" />
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
