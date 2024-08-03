<template>
    <head>
      <title> Home </title>
    </head>
    <AppLayout :canLogin="canLogin" :canRegister="canRegister">
        <template #content>
            <div class="mx-auto max-w-7xl h-full px-4 sm:px-6 lg:px-8">
                <div class="w-full h-full min-h-screen pt-5">
                    <SearchBar />
                    <div class="grid grid-cols-2 sm:grid-cols-5 xl:grid-cols-5 gap-8 xl:gap-x-0">
                        <BookCard
                            v-for="book in books.data"
                            :key="book.id"
                            :bookId="book.id"
                            :title="book.title"
                            :description="book.description"
                            :genre="book.genre"
                            :price="book.price"
                            :borrowStatus="book.alreadyBorrowed"
                            @updateBorrowStatus="updateBookStatus"
                        />
                    </div>
                </div>
                <Pagination :links="books.links"/>
            </div>
        </template>
    </AppLayout>
</template>

<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import SearchBar from '@/Components/MyComponents/SearchBar.vue';
    import BookCard from '@/Components/MyComponents/BookCard.vue';
    import Pagination from '@/Components/MyComponents/Pagination.vue';

    const props = defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        books: Object
    });

    const updateBookStatus = (bookId, status) => {
        const book = props.books.data.find(b => b.id === bookId);
        if (book) {
            book.alreadyBorrowed = status.isBorrowed;
        }

    };
</script>
