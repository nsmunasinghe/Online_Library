<template>
    <head>
      <title> Ny Books </title>
    </head>
    <AppLayout>
        <template #content>
            <div class="h-full min-h-screen px-2 pt-5">
                <div class="mb-5">
                    <h1 class="my-5 font-serif text-4xl text-sky-200 text-center uppercase">My Books</h1>
                    <hr class="border-gray-700 mx-10">
                </div>
                <h1 v-if="!myBooks || (Array.isArray(myBooks) && myBooks.length === 0)" class="mt-52 text-4xl text-slate-700 flex justify-center">No any borrowed books</h1>
                <BookTable v-else :books="myBooks"/>
                <!-- <div class="flex justify-center items-center">
                </div> -->
            </div>
        </template>
    </AppLayout>
</template>

<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import BookTable from '@/Components/MyComponents/BookTable.vue';

    defineProps({
        myBooks: {
            type: Array,
        }
    });
</script>
