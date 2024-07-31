<script setup>
import { Link } from '@inertiajs/vue3';
import Logo from '@/Components/MyComponents/Logo.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center px-7 pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="mb-5">
            <Link href="/" class="flex flex-shrink-0 items-center sm:relative">
                <Logo class="self-center" :isLarge="true"/>
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
