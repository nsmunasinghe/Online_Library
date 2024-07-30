<template>
    <div class="my-10 flex justify-center">
        <div>
            <Component
            v-for="(link, index) in links"
            :is="link.url ? 'a' : 'span'"
            :href="link.url"
            v-html="link.label"
            class="mx-2 text-blue-300 text-lg"
            :class="{
                'text-blue-300/[0.1] cursor-default': !link.url,
                'px-3 py-1 rounded-md bg-white/[0.1]': link.url && !link.active && !(index === 0 || index === links.length - 1),
                'text-sm': index === 0 || index === links.length - 1,
                'hover:text-cyan-500': link.url && (index === 0 || index === links.length - 1),
                'px-3 py-1 rounded-md font-bold text-white bg-white/[0.3]': link.active,
            }"
        />
        </div>
    </div>
</template>

<script setup>

    defineProps({
        links: Array
    })

</script>
