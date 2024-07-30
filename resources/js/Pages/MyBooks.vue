<template>
    <head>
      <title> Ny Books </title>
    </head>
    <AppLayout>
        <template #content>
            <div class="h-full min-h-screen px-2">
                <BookTable v-if="myBooks" :books="myBooks"/>
                <div v-else class="flex justify-center items-center">
                    <h1 class="text-slate-400">No any borrowed books</h1>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import BookTable from '@/Components/MyComponents/BookTable.vue';

    defineProps({
        myBooks: {
            type: Object,
        }
    });
</script>
