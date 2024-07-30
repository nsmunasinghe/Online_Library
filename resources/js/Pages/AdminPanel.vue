<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminBooksTable from '@/Components/MyComponents/AdminBooksTable.vue';

defineProps({
    books: {
        type: Array,
    }
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), { onFinish: () => form.reset('password'), });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Admin Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="flex flex-col lg:flex-row max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex-grow h-screen overflow-scroll scroll-smooth noScroll">
                    <AdminBooksTable :books='books'/>
                </div>
                <!-- Inputs -->
                <div class="lg:w-1/3">
                    <div class="p-4 mx-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="title" value="Title" />

                                <input
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="X-Men"
                                />

                            </div>

                            <div class="mt-4">
                                <InputLabel for="genre" value="Genre" />

                                <input
                                    id="genre"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="Comics"
                                />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="price" value="Price" />

                                <input
                                    id="price"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="0.00"
                                />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="description" value="Description" />

                                <textarea
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="Comics"
                                />
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <button
                                    class="w-9 h-9 mr-4 flex justify-center items-center bg-red-500 rounded-md font-extrabold text-sm text-white uppercase hover:bg-red-700 transition ease-in-out duration-150"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    <i class="fa-solid fa-rotate-right"></i>
                                </button>
                                <button
                                    class="w-1/2 h-9 flex justify-center items-center bg-green-500 rounded-md font-extrabold text-sm text-white uppercase hover:bg-green--700 transition ease-in-out duration-150"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Add
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
    .noScroll::-webkit-scrollbar {
        display: none;
    }
</style>
