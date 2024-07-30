<template>
    <div 
        class="flex justify-center bg-none"
    >
        <div class="w-[180px] h-[265px] flex flex-col p-2 items-center justify-between bg-slate-700 rounded-md shadow-lg ring-4 hover:ring-sky-500">
            <p class="text-white text-lg font-bold">{{ title }}</p>
            <p class="text-white text-sm text-center line-clamp-3">{{ description }}</p>
            <p class="text-white text-xs">{{ genre }}</p>
            <p class="text-white text-lg font-bold">Rs. {{ price }}</p>

            <button
                @click="showConfirmationAlert"
                class="w-full p-1 flex justify-center items-center rounded-lg font-extrabold text-lg hover:bg-opacity-80"
                :class="{
                    'bg-green-300 hover:bg-green-500': !isBorrowed,
                    'bg-red-500 text-white hover:bg-red-700': isBorrowed
                }"
            >
                {{ isBorrowed ? 'Borrowed' : 'Borrow' }}
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
const emit = defineEmits(['updateBorrowStatus']);

watch(isBorrowed, (newVal) => {
    emit('updateBorrowStatus', props.bookId, newVal);
});

onMounted(async () => {
    const res = await axios.get(`api/books/${props.bookId}/status`);
    isBorrowed.value = res.data.isBorrowed;
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
