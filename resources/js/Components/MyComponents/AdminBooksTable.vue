<template>
    <div>
        <!-- Table -->
        <div class="flex flex-col mx-2 sm:mx-10">
            <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden rounded-lg">
                        <table class="min-w-full">
                            <tbody>
                                <tr v-for="book in books" :key="book.id" class="bg-slate-800 mb-2 rounded-lg">
                                    <td class="p-3 sm:px-6 sm:py-4 whitespace-nowrap flex flex-grow">
                                        <div class="flex flex-col grow text-wrap">
                                            <h1 class="text-xl font-bold text-white">
                                                {{ book.title }} <span class="text-sm text-white"> &nbsp | &nbsp {{ book.genre }}</span>
                                            </h1>
                                            <p class="text-sm text-gray-400 line-clamp-2">
                                                {{ book.description }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="sm:px-6 sm:py-4 whitespace-nowrap">
                                        <div class="flex sm:flex-col gap-10 sm:gap-0 items-center">
                                            <h3 class="text-sm font-bold text-white">
                                                Price
                                            </h3>
                                            <p class="text-sm text-gray-400">
                                                Rs. {{ book.price }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-3 sm:px-6 sm:py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link
                                            :href="`/api/books/${book.id}`"
                                            class="px-5 py-3 font-bold text-black hover:text-white bg-white hover:bg-red-600 rounded-lg shadow"
                                        >Delete</Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';

    defineProps({
        books: {
            type: Array,
        }
    });
</script>