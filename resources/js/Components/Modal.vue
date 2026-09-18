<script setup>
    import { watch } from 'vue'

    const props = defineProps({
        show: {
            type: Boolean,
            default: false,
        },
    })

    const emit = defineEmits(['close'])

    watch(
        () => props.show,
        (show) => {
            document.body.style.overflow = show ? 'hidden' : ''
        }
    )

    const close = () => {
        emit('close')
    }
</script>

<template>
    <Teleport to="body">
        <div
            v-if="show"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <!-- Backdrop -->
            <div
                class="absolute inset-0 bg-black/50"
                @click="close"
            ></div>

            <!-- Modal -->
            <div
                class="relative z-10 w-full max-w-lg rounded-xl bg-white shadow-xl"
            >
                <slot />
            </div>
        </div>
    </Teleport>
</template>