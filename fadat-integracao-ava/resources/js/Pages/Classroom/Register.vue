<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { watch, ref } from 'vue';

const props = defineProps({
    classrooms: {
        type: Array,
        default: () => [],
    },
});

const showAcademicBuilding = ref(false);

const form = useForm({
    class_number: '',
    person_class: '',
    academic_building: '',
});

watch(
    () => form.person_class,
        (newVal) => {
            showAcademicBuilding.value = newVal === 'PR' || newVal === 'HI';
            if (newVal !== 'PR') {
                form.academic_building = '';
            }
    }
);

const submit = () => {
    form.post(route('classroom.store'));
};
</script>

<template>
    <Head title="Classroom Register" />

    <AuthenticatedLayout>
        <template #header>
                <div class="flex items-baseline justify-between mb-6">
                    <h1 class="text-3xl font-semibold">Cadastrar Sala</h1>
                    <Link
                        :href="route('classroom.index')"
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
                            <InputLabel for="class_number" value="Numero da Sala" class="text-white" />
                            
                            <TextInput
                                id="class_number"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.class_number"
                                autofocus
                                autocomplete="class_number"
                            />

                            <InputError class="mt-2" :message="form.errors.class_number" />
                        </div>

                        <div>
                            <InputLabel value="Tipo" class="text-white" />
                            <div class="flex gap-4 mt-2 text-white">
                                    <label class="flex items-center space-x-2">
                                        <input
                                            type="radio"
                                            value="PR"
                                            v-model="form.person_class"
                                        />
                                        <span>Presencial</span>
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <input
                                            type="radio"
                                            value="ED"
                                            v-model="form.person_class"
                                        />
                                        <span>EAD</span>
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <input
                                            type="radio"
                                            value="HI"
                                            v-model="form.person_class"
                                        />
                                        <span>Híbrido</span>
                                    </label>
                            </div>
                            <InputError class="mt-2" :message="form.errors.person_class" />
                        </div>

                        <div v-if="showAcademicBuilding">
                            <InputLabel for="academic_building" value="Prédio Acadêmico" class="text-white" />
                            
                            <TextInput
                                id="academic_building"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.academic_building"
                                autocomplete="academic_building"
                            />

                            <InputError class="mt-2" :message="form.errors.academic_building" />
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