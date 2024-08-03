<template>
    <div
        class="flex justify-center bg-none"
    >
        <div
            class="w-[160px] h-[220px] sm:w-[180px] sm:h-[265px] flex flex-col p-2 items-center justify-between rounded-md shadow-lg ring-4"
            :class="{
                'bg-gradient-to-tr from-black via-blue-900 to-blue-500 ring-blue-900 hover:ring-blue-600': !status.isBorrowed,
                'bg-gradient-to-tr from-black via-amber-900 to-yellow-700 ring-yellow-600 hover:ring-yellow-400': (status.isBorrowed && status.byYou),
                'bg-gradient-to-tr from-black via-red-900 to-red-500 ring-red-700 hover:ring-red-500': status.isBorrowed && !status.byYou,
            }"
        >
            <p class="font-serif text-white text-sn sm:text-md text-center font-extrabold p-1 bg-black/25 rounded-md w-full">{{ title }}</p>
            <p class="text-white/50 text-xs sm:text-sm text-center line-clamp-3">{{ description }}</p>
            <p class="text-white text-xs italic">{{ genre }}</p>
            <p class="text-white text-md sm:text-lg font-bold">Rs. {{ price }}</p>

            <button
                @click="showConfirmationAlert"
                class="w-full p-1 flex flex-shrink-1 truncate justify-center items-center rounded-lg font-extrabold text-md sm:text-lg hover:bg-opacity-80 shadow-md"
                :class="{
                    'bg-blue-600 text-white hover:text-white hover:bg-blue-400': !status.isBorrowed,
                    'bg-yellow-600 text-black hover:bg-yellow-300': (status.isBorrowed && status.byYou),
                    'bg-red-700 text-white hover:bg-red-500': status.isBorrowed && !status.byYou,
                }"
            >
            <i v-if="status.byYou" class="fa-solid fa-circle-check mr-2 animate-pulse"/> {{ status.isBorrowed ? status.byYou ? 'You Borrowed' :'Borrowed' : 'Borrow' }}
            </button>
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
    borrowStatus: {
        type: Boolean,
        default: false,
        required: true
    }
});

const { props: pageProps } = usePage();
const emit = defineEmits(['updateBorrowStatus']);

const status = ref({
    isBorrowed: props.borrowStatus,
    byYou: false
});

watch(() => status.value, (newStatus) => {
    emit('updateBorrowStatus', props.bookId, newStatus);
}, { deep: true });

onMounted(async () => {
    try{
        const res = await axios.get(`api/books/${props.bookId}/status`);
        status.value.isBorrowed = res.data.isBorrowed;
        status.value.byYou = res.data.borrowedUserId === pageProps.auth.user.id;
    }catch(e){
        console.log('Error when Mounting Book Card:', e);
    }
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
            status.value.byYou = true;
            status.value.isBorrowed = true;

            Swal.fire({
                position: "center",
                icon: "success",
                title: "Successfully Borrowed",
                showConfirmButton: false,
                timer: 1500
            });
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
