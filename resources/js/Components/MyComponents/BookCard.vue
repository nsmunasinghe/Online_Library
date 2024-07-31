<template>
    <div
        class="flex justify-center bg-none"
    >
        <div
            class="w-[160px] h-[220px] sm:w-[180px] sm:h-[265px] flex flex-col p-2 items-center justify-between rounded-md shadow-lg ring-4"
            :class="{
                'bg-gradient-to-tr from-black via-blue-900 to-blue-500 ring-blue-900 hover:ring-blue-600': !isBorrowed,
                'bg-gradient-to-tr from-black via-amber-900 to-yellow-700 ring-yellow-600 hover:ring-yellow-400': (isBorrowed && isBorrowedByYou),
                'bg-gradient-to-tr from-black via-red-900 to-red-500 ring-red-700 hover:ring-red-500': isBorrowed && !isBorrowedByYou,
            }"
        >
            <p class="font-serif text-white text-sn sm:text-md text-center font-extrabold p-1 bg-black/25 rounded-md w-full">{{ title }}</p>
            <p class="text-white/50 text-xs sm:text-sm text-center line-clamp-3">{{ description }}</p>
            <p class="text-white text-xs italic">{{ genre }}</p>
            <p class="text-white text-md sm:text-lg font-bold">Rs. {{ price }}</p>

            <button
                @click="showConfirmationAlert"
                class="w-full p-1 flex justify-center items-center rounded-lg font-extrabold text-md sm:text-lg hover:bg-opacity-80 shadow-md"
                :class="{
                    'bg-blue-600 text-white hover:text-white hover:bg-blue-400': !isBorrowed,
                    'bg-yellow-600 text-black hover:bg-yellow-300': (isBorrowed && isBorrowedByYou),
                    'bg-red-700 text-white hover:bg-red-500': isBorrowed && !isBorrowedByYou,
                }"
            >
            <i v-if="isBorrowedByYou" class="fa-solid fa-circle-check mr-2 animate-pulse"/> {{ isBorrowed ? isBorrowedByYou ? 'You Borrowed' :'Borrowed' : 'Borrow' }}
            </button>

            <!-- <button
                @click="borrowBook"
                class="w-full p-1 flex justify-center items-center bg-green-300 rounded-lg font-extrabold text-lg hover:bg-green-500"
            >
                Borrow
            </button> -->

        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2'

const props = defineProps({
    bookId: {
        type: Number,
        required: true
    },
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    genre: {
        type: String,
        required: true
    },
    price: {
        type: Number,
        required: true
    },
    status: {
        type: Boolean,
        default: false,
        required: true
    }
});

const { props: pageProps } = usePage();
const isBorrowed = ref(props.status);
const isBorrowedByYou = ref(false);
const emit = defineEmits(['updateBorrowStatus']);

watch([isBorrowed, isBorrowedByYou], ([newBorrowed, newBorrowedByYou]) => {
    emit('updateBorrowStatus', props.bookId, newBorrowed, newBorrowedByYou);
});

onMounted(async () => {
    const res = await axios.get(`api/books/${props.bookId}/status`);
    isBorrowed.value = res.data.isBorrowed;
    isBorrowedByYou.value = res.data.borrowedUserId === pageProps.auth.user.id;
});

// -------------------------- ALERT ---------------------
const showConfirmationAlert = () => {
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
            borrowBook()
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

const borrowBook = async () => {

    try {
        const response = await axios.post(`api/books/${props.bookId}/borrow`, { user_id: pageProps.auth.user.id });

        if (response.status === 200) {
            isBorrowedByYou.value = true;
            isBorrowed.value = true

            Swal.fire({
                position: "center",
                icon: "success",
                title: "Successfully Borrowed",
                showConfirmButton: false,
                timer: 1500
            });

            console.log(pageProps.auth.user ? true : false);
        }
    } catch (error) {
        console.error('Error borrowing book:', error);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Failed to borrow the book. Please try again.",
            showConfirmButton: false,
            timer: 1500
        });
}
};

</script>
