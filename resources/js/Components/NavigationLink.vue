<script setup>
    import { computed } from 'vue'
    import { Link, usePage } from '@inertiajs/vue3'

    const props = defineProps({
        href: {
            type: String,
            required: true,
        },
    })

    const page = usePage()

    const isActive = computed(() => {
        return page.url === props.href
    })
</script>

<template>
    <Link
        :href="href"
        :class="[
            'block rounded-lg px-4 py-2 text-sm font-medium transition',
            isActive
                ? 'bg-gray-900 text-white'
                : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900',
        ]"
    >
        <slot />
    </Link>
</template>