<script setup>
    import { Link } from '@inertiajs/vue3'
    
    defineProps({
        columns: {
            type: Array,
            required: true,
        },
        rows: {
            type: Array,
            required: true,
        },
        pagination: {
            type: Object,
            default: null,
        },
    })

    const emit = defineEmits(['edit', 'delete'])
</script>

<template>
    <div class="overflow-hidden rounded-xl bg-white shadow">
        <table class="w-full">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th
                        v-for="column in columns"
                        :key="column.key"
                        class="px-6 py-3 text-left text-sm font-semibold"
                    >
                        {{ column.label }}
                    </th>

                    <th class="px-6 py-3 text-right text-sm font-semibold">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y">
                <tr v-if="rows.length === 0">
                    <td
                        :colspan="columns.length + 1"
                        class="px-6 py-12 text-center text-sm text-gray-500"
                    >
                        No categories found.
                    </td>
                </tr>

                <tr
                    v-for="row in rows"
                    :key="row.id"
                >
                    <td
                        v-for="column in columns"
                        :key="column.key"
                        class="px-6 py-4 text-sm"
                    >
                        {{ row[column.key] }}
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <button
                                type="button"
                                class="rounded-lg px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                @click="emit('edit', row)"
                            >
                                Edit
                            </button>

                            <button
                                type="button"
                                class="rounded-lg px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50"
                                @click="emit('delete', row)"
                            >
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- paginate -->
        <div
            v-if="pagination"
            class="flex items-center justify-between border-t px-6 py-4"
        >
            <p class="text-sm text-gray-600">
                Page {{ pagination.current_page }} of {{ pagination.last_page }}
            </p>

            <div class="flex gap-2">
                <Link
                    v-if="pagination.prev_page_url"
                    :href="pagination.prev_page_url"
                    class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50"
                >
                    Previous
                </Link>

                <Link
                    v-if="pagination.next_page_url"
                    :href="pagination.next_page_url"
                    class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50"
                >
                    Next
                </Link>
            </div>
        </div>
    </div>
</template>