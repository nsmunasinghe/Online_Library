<template>
    <div class="bg-gray-900 h-full">
        <NavBar :canLogin="canLogin" :canRegister="canRegister"/>
        <slot name="content"/>
        <Footer />
    </div>
</template>

<script setup>
    import NavBar from '@/Components/MyComponents/NavBar.vue'
    import Footer from '@/Components/MyComponents/Footer.vue'

    defineProps({
        canLogin: {
            type: Boolean,
        },
        canRegister: {
            type: Boolean,
        },
    })

</script>

<style lang="scss" scoped>

</style>
