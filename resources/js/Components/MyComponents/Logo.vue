<template>
    <h1
        class="flex text-white font-bold items-center"
        :class="{'text-5xl sm:text-7xl': isLarge, 'text-xl sm:text-2xl': !isLarge}"
    >
        <div class="-rotate-[30deg]">
            <span class="text-teal-500" :class="{'text-6xl sm:text-8xl': isLarge, 'text-2xl sm:text-3xl': !isLarge}">e</span>
        </div>
        Library
    </h1>
</template>

<script setup>

defineProps({
    isLarge: Boolean,
})

</script>
