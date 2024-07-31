<template>
    <footer class="flex bg-white dark:bg-gray-950 h-36 sm:h-14">
        <div class="container flex flex-col items-center justify-between px-4 mx-auto sm:flex-row">
            <p class="flex text-xs truncate text-slate-600 text-center flex-1 order-3 sm:order-1">© Copyright 2021 Nimesh S. Munasinghe. All Rights Reserved.</p>

            <Link href="/" class="flex flex-2 items-center order-1 sm:order-2 mt-3 mb-5 sm:mt-0 sm:mb-0">
                <Logo class="self-center" :isLarge="false"/>
            </Link>

            <div class="flex flex-1 justify-end order-2 sm:order-3">
                <Link href="#" class="mx-2 text-gray-600 transition-colors duration-300 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400" aria-label="Reddit">
                    <i class="fa-brands fa-facebook-f w-5 h-5 fill-current"></i>
                </Link>

                <Link href="#" class="mx-2 text-gray-600 transition-colors duration-300 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400" aria-label="Facebook">
                    <i class="fa-brands fa-instagram w-5 h-5 fill-current"></i>
                </Link>

                <Link href="#" class="mx-2 text-gray-600 transition-colors duration-300 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400" aria-label="Github">
                    <i class="fa-brands fa-telegram w-5 h-5 fill-current"></i>
                </Link>
            </div>
        </div>
    </footer>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import Logo from '@/Components/MyComponents/Logo.vue';

</script>
