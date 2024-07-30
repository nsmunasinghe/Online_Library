<template>
    <div>
        <!-- Table -->
        <div class="flex flex-col mx-2 sm:mx-10">
            <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden rounded-lg">
                        <table class="min-w-full">
                            <tbody>
                                <tr v-for="book in books" class="flex bg-white mb-2 rounded-lg">
                                    <td class="p-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                        <div class="w-[90px] h-[160px] sm:w-[75px] sm:h-[100px] bg-slate-400 flex justify-center items-center rounded-md shadow-md text-white italic">Image</div>
                                    </td>
                                    <div class="flex flex-col flex-grow sm:flex-row items-center">
                                        <td class="p-3 sm:px-6 sm:py-4 whitespace-nowrap flex flex-grow">
                                            <div class="flex flex-col grow text-wrap">
                                                <h1 class="text-xl font-bold text-gray-900">
                                                    {{ book.title }} <span class="text-sm text-gray-500"> &nbsp | &nbsp {{ book.genre }}</span>
                                                </h1>
                                                <p class="text-sm text-gray-500 line-clamp-3">
                                                    {{ book.description }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="sm:px-6 sm:py-4 whitespace-nowrap">
                                            <div class="flex sm:flex-col gap-10 sm:gap-0 item-center">
                                                <h3 class="text-sm font-medium text-gray-900">
                                                    Due Date
                                                </h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ book.price }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="p-3 sm:px-6 sm:py-4 my-3 sm:my-0 whitespace-nowrap text-right text-sm font-medium">
                                            <!-- <Link
                                                href="#"
                                                class="px-5 py-3 text-slate-200 hover:text-white bg-black hover:bg-red-600 rounded-lg shadow"
                                            >Check Out</Link> -->

                                            <button
                                                @click="showConfirmationAlert(book.id)"
                                                class="px-5 py-3 text-slate-200 hover:text-white bg-black hover:bg-red-600 rounded-lg shadow"
                                            >
                                                Check Out
                                            </button>
                                        </td>
                                    </div>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <Pagination :links="books.links"/>
    </div>
</template>

<script setup>
    import { ref, watch } from 'vue';
    import { Link, usePage } from '@inertiajs/vue3';
    import axios from 'axios';
    import Pagination from '@/Components/MyComponents/Pagination.vue';

    defineProps({
        books: {
            type: Object,
        }
    });

    const { props: pageProps } = usePage();
    const isReturned = ref(false);

    watch(isReturned, (newVal, oldVal) => {
        if (newVal !== oldVal) {
            location.reload();
        }
    });

    const showConfirmationAlert = (id) => {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: true
        });

        swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            reverseButtons: true,
            confirmButtonColor: '#00bc41',
            cancelButtonColor: '#c10000',
        }).then((result) => {
            if (result.isConfirmed) {
                returnBook(id)
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "You cansel the request!",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    const returnBook = async (id) => {

        try {
            const res = await axios.post(`api/books/${id}/return`, { user_id: pageProps.auth.user.id });

            if (res.status === 200) {
                isReturned.value = !isReturned.value 
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Successfully Returned",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        } catch (error) {
            console.error('Error returning book:', error);
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Failed to return the book. Please try again.",
                showConfirmButton: false,
                timer: 1500
            });
        }
    };
</script>

