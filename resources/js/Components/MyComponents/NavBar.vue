<template>
    <nav class="bg-gray-900 px-3 border-b border-slate-700 fixed top-0 w-full z-10">
        <!-- Desktop menu -->
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-20 items-center justify-between">
                <div class="flex flex-1 h-full sm:items-stretch sm:justify-start">
                    <Link href="/" class="flex flex-shrink-0 items-center">
                        <Logo class="self-center"/>
                    </Link>
                    <div class="hidden sm:ml-10 sm:flex sm:self-center">
                        <Link href="/" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white active:border-b-teal-500">Browse</Link>
                        <Link v-if="$page.props.auth.user" href="/mybooks" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">My Books</Link>
                    </div>
                </div>

                <!-- Profile -->
                <div>
                    <!-- Profile Dropdown -->
                    <div v-if="$page.props.auth.user" class="hidden relative ml-3 sm:block">
                        <!-- Dropdown button-->
                        <div>
                            <button
                                type="button"
                                class="relative flex rounded-2xl bg-gray-950 text-sm font-extrabold text-gray-400 hover:text-white px-5 py-2 focus:outline-none"
                                id="user-menu-button"
                                aria-expanded="false"
                                aria-haspopup="true"
                                @click="toggleProfileDropdown"
                            >
                                Hello, {{ firstName }}
                            </button>
                        </div>

                        <!-- Dropdown -->
                        <div
                            v-if="isProfileDropdownVisible"
                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu"
                            aria-orientation="vertical"
                            aria-labelledby="user-menu-button"
                            tabindex="-1"
                        >
                            <Link href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Profile</Link>
                            <Link :href="route('logout')" method="post" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Sign out</Link>
                        </div>
                    </div>

                    <div v-else class="mr-7 sm:mr-none">
                        <Link :href="route('login')" class="mr-6 text-sm text-slate-400 font-bold hover:text-white">Log in</Link>
                        <Link
                            :href="route('register')"
                            class="text-sm text-slate-400 font-bold hover:text-white"
                        >Register</Link>
                    </div>
                </div>

                <!-- Mobile menu button-->
                <div class="flex items-center sm:hidden">
                    <p v-if="$page.props.auth.user" class="mr-5 text-sm text-gray-300 truncate">Hello, {{ firstName }}</p>
                    <button
                        id="mobile-menu-button"
                        type="button"
                        class="relative inline-flex items-center justify-center rounded-md p-3 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none"
                        aria-controls="mobile-menu"
                        aria-expanded="false"
                        @click="toggleMobileMenu"
                    >
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="sm:hidden w-full" id="mobile-menu" v-if="isMobileMenuVisible">
            <div class="absolute z-10 right-5 bg-slate-800 rounded-bl-2xl rounded-br-2xl w-[91%]">
                <div class="space-y-2 px-2 pb-3 pt-2 flex flex-col">
                    <Link href="/" class="block w-full text-center rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Home</Link>
                    <Link v-if="$page.props.auth.user" href="/mybooks" class="block w-full text-center rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">My Books</Link>
                    <Link :href="route('logout')" method="post" class="block w-full text-center rounded-md rounded-bl-2xl rounded-br-2xl px-3 py-2 text-base font-bold text-gray-300 bg-black hover:bg-red-600 hover:text-white">Log Out</Link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
    import { ref, computed, onBeforeUnmount } from 'vue';
    import { Link, usePage } from '@inertiajs/vue3';
    import Logo from '@/Components/MyComponents/Logo.vue';

    const { auth } = usePage().props;
    const userName = auth.user?.name || '';

    const firstName = computed(() => userName.split(' ')[0]);
    const isProfileDropdownVisible = ref(false);
    const isMobileMenuVisible = ref(false);

    const toggleProfileDropdown = () => {
        isProfileDropdownVisible.value = !isProfileDropdownVisible.value;
    };

    const toggleMobileMenu = () => {
        isMobileMenuVisible.value = !isMobileMenuVisible.value;
    };

    const closeDropdown = (event) => {
        if (!event.target.closest('#user-menu-button')) {
            isProfileDropdownVisible.value = false;
        }
        if (!event.target.closest('#mobile-menu-button')) {
            isMobileMenuVisible.value = false;
        }
    };

    document.addEventListener('click', closeDropdown);

    onBeforeUnmount(() => {
        document.removeEventListener('click', closeDropdown);
    });

</script>
