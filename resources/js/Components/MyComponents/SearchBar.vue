<template>
    <!-- component -->
    <div class='flex flex-col items-center justify-center mt-5 mb-10'>
        <div class="w-full sm:w-1/2">
            <!-- SearchBar -->
            <div class="flex rounded-full bg-[rgb(5,11,19)] px-2 w-full max-w-[600px]">
                <input
                    type="text"
                    class="w-full flex bg-transparent p-3 text-[#cccccc] border-0 ring-0 focus:ring-0 mr-2"
                    v-model="searchQuery"
                    @keyup.enter="searchBooks"
                    placeholder="Search books by title, description, or genre"
                />

                <button
                    type="submit"
                    class="relative p-2 bg-transparent rounded-full"
                    @click="searchBooks"
                >
                    <i class="fa-solid fa-magnifying-glass" style="color: #c7dbff;"></i>
                </button>
            </div>

        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue'
    import { usePage } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia';

    // Initialize reactive variables for search query and books
    const searchQuery = ref(usePage().props.query || '');
    const books = ref(usePage().props.books);

    // When the component is mounted, initialize the search query and books with server data
    onMounted(() => {
        searchQuery.value = usePage().props.query || '';
        books.value = usePage().props.books;
    });

    // Define a function to perform the search
    const searchBooks = () => {
        Inertia.get('/', { query: searchQuery.value }, { preserveState: true });
    };

</script>
