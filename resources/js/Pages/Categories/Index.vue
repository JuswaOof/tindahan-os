<script setup>
    import { useForm, usePage } from '@inertiajs/vue3'
    import { ref, watch } from 'vue'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import Modal from '@/Components/Modal.vue'
    import Swal from 'sweetalert2'

    defineProps({
        categories: {
            type: Object,
            required: true,
        },
    })

    const page = usePage();

    const columns = [
        { key: 'id', label: 'ID' },
        { key: 'name', label: 'Name' },
        { key: 'description', label: 'Description' },
    ]

    const form = useForm({
        name: '',
        description: '',
    })

    const showToast = (icon, title) => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon,
            title,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })
    }

    const showCategoryModal = ref(false)
    const editingCategory = ref(null)

    const editCategory = (category) => {
        editingCategory.value = category

        form.name = category.name
        form.description = category.description ?? ''

        showCategoryModal.value = true
    }

    const deleteCategory = (category) => {
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete "${category.name}".`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                form.delete(`/categories/${category.id}`, {
                    onSuccess: (page) => {
                        const message = page.props.flash?.success
                            ?? page.props.flash?.error

                        if (message) {
                            const icon = page.props.flash?.error
                                ? 'error'
                                : 'success'

                            showToast(icon, message)
                        }
                    },
                })
            }
        })
    }

    watch(
        () => page.props.flash?.error,
        (message) => {
            console.log('Flash error:', message)

            if (message) {
                showToast('error', message)
            }
        },
        { immediate: true }
    )

    const closeCategoryModal = () => {
        showCategoryModal.value = false
        form.reset()
        editingCategory.value = null
    }

</script>

<template>
    <AuthenticatedLayout>
        <h1 class="mb-6 text-2xl text-center font-bold">Categories</h1>

        <button
            type="button"
            class="mb-6 rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white"
            @click="showCategoryModal = true"
            >
            Add Category
        </button>

        <Modal
            :show="showCategoryModal"
            @close="closeCategoryModal"
            >
            <form
                @submit.prevent="
                    editingCategory
                        ? form.put(`/categories/${editingCategory.id}`, {
                            onSuccess: () => {
                                form.reset()
                                editingCategory = null
                                showCategoryModal = false
                                showToast('success', 'Category updated successfully')
                            },
                            onError: () => {
                                showToast('error', 'Please check the form for errors')
                            },
                        })
                        : form.post('/categories', {
                            onSuccess: () => {
                                form.reset()
                                showCategoryModal = false
                                showToast('success', 'Category added successfully')
                            },
                            onError: () => {
                                showToast('error', 'Please check the form for errors')
                            },
                        })
                "
            >
                <div class="border-b px-6 py-4">
                    <h2 class="text-lg font-semibold">
                        {{ editingCategory ? 'Edit Category' : 'Add Category' }}
                    </h2>
                </div>

                <div class="space-y-4 p-6">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Name
                        </label>

                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2"
                        />

                        <p
                            v-if="form.errors.name"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Description
                        </label>

                        <textarea
                            v-model="form.description"
                            rows="3"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2"
                        ></textarea>

                        <p
                            v-if="form.errors.description"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.description }}
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t px-6 py-4">
                    <button
                        type="button"
                        class="rounded-lg border px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        @click="closeCategoryModal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Saving...' : editingCategory ? 'Update Category' : 'Add Category' }}
                    </button>
                </div>
            </form>
            
        </Modal>

        <DataTable
            :columns="columns"
            :rows="categories.data"
            :pagination="categories"
            @edit="editCategory"
            @delete="deleteCategory"
        />
    </AuthenticatedLayout>
</template>