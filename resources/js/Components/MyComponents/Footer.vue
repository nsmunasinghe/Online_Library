<template>
    <footer class="bg-white dark:bg-gray-950">
        <div class="container flex flex-col items-center justify-between p-6 mx-auto space-y-4 sm:space-y-0 sm:flex-row">
            <Link href="/" class="flex flex-shrink-0 items-center">
                <Logo />
            </Link>

            <p class="text-sm text-slate-600 text-center">© Copyright 2021 Nimesh S. Munasinghe. All Rights Reserved.</p>

            <div class="flex -mx-2">
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
