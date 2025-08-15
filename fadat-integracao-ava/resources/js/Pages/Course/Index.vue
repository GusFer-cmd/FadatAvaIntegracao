<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head, Link } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';

defineProps({
    courses: {
        type: Array,
        default: () => [],
    },
});


const editCourse = (course) => { 
  const encodedId = btoa(course.id);
  router.get(route('course.edit', encodedId));
};

const removeCourse = (course) => {
  if (confirm(`Deseja realmente deletar o curso "${course.name}"?`)) {
    router.delete(route('course.delete', course.id));
  }
};
</script>

<template>
    <Head title="Course Index" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 p-6 text-gray-900 dark:text-gray-100">
                <div class="flex items-baseline justify-between mb-2">
                  <h1 class="text-3xl font-semibold mb-6">Cursos</h1>
                    <Link
                      :href="route('course.create')"
                      class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                      Criar Curso
                    </Link>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div v-for="course in courses" :key="course.id" class="bg-[#E9E9E9] rounded-lg shadow p-5 flex flex-col justify-between dark:bg-gray-700">
                    <h2 class="text-xl font-medium text-gray-800 dark:text-gray-100 truncate">{{ course.name || course.title || 'Sem título' }}</h2>
                    
                    <div class="mt-4 flex space-x-3 justify-end">
                        <button
                          @click="editCourse(course)"
                          class="text-blue-600 hover:text-blue-800 transition"
                          aria-label="Editar curso"
                        >
                           <Pencil class="w-5 h-5" />
                        </button>
                        
                        <button
                          @click="removeCourse(course)"
                          class="text-red-600 hover:text-red-800 transition"
                          aria-label="Remover curso"
                        >
                          <Trash2 class="w-5 h-5" />
                        </button>
                    </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>