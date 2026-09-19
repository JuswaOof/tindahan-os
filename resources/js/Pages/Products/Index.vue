<script setup>
    import { useForm, usePage } from '@inertiajs/vue3'
    import { ref } from 'vue'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import Modal from '@/Components/Modal.vue'
    import Swal from 'sweetalert2'

    defineProps({
        products: {
            type: Object,
            required: true,
        },
        categories: {
            type: Array,
            required: true,
        },
    });

    const page = usePage();

    const columns = [
        { key: 'id', label: 'ID' },
        { key: 'name', label: 'Name' },
        { key: 'sku', label: 'SKU' },
        { key: 'description', label: 'Description' },
        { key: 'unit', label: 'UNIT' },
    ]

    const form = useForm({
        name: '',
        sku: '',
        unit: '',
        category_id: '',
        description: '',
    })

    const showProductModal = ref(false)
    const editingProduct = ref(null)

    const closeProductModal = (product) => {
        showProductModal.value = false
        form.reset()
        form.clearErrors()
        editingProduct.value = null
    }

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

    const editProduct = (product) => {
        editingProduct.value = product
        form.name = product.name
        form.description = product.description ?? ''
        form.sku = product.sku ?? ''
        form.unit = product.unit ?? ''
        form.category_id = product.category.id
        showProductModal.value = true
        console.log(product.category.id);
    }

    const deleteProduct = (product) => {
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete "${product.name}".`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                form.delete(`/products/${product.id}`, {
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
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="mb-6 text-2xl text-center font-bold">
            Products
        </h1>

        <button
            type="button"
            class="mb-6 rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white"
            @click="showProductModal = true"
            >
            Add Product
        </button>

        <Modal 
            :show="showProductModal"
            @close="closeProductModal"
            >
            <form
                @submit.prevent="
                    editingProduct
                        ? form.put(`/products/${editingProduct.id}`, {
                            onSuccess: () => {
                                form.reset()
                                editingProduct = null
                                showProductModal = false
                                showToast('success', 'Product updated successfully')
                            },
                            onError: () => {
                                showToast('error', 'Please check the form for errors')
                            },
                        })
                        : form.post('/products', {
                            onSuccess: () => {
                                form.reset()
                                showProductModal = false
                                showToast('success', 'Product added successfully')
                            },
                            onError: () => {
                                showToast('error', 'Please check the form for errors')
                            },
                        })
                "
                >
                <div class="border-b px-6 py-4">
                    <h2 class="text-lg font-semibold">
                        {{ editingProduct ? 'Edit Product' : 'Add Product' }}
                    </h2>
                </div>

                <div class="space-y-4 p-6">
                    <!-- name -->
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
                    <!-- sku -->
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            SKU
                        </label>

                        <input
                            v-model="form.sku"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2"
                        />

                        <p
                            v-if="form.errors.sku"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.sku }}
                        </p>
                    </div>
                    <!-- category -->
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Category
                        </label>

                        <select
                            v-model="form.category_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2"
                        >
                            <option value="" disabled>
                                Select a category
                            </option>

                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>

                        <p
                            v-if="form.errors.category_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.category_id }}
                        </p>
                    </div>

                    <!-- unit -->
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Unit
                        </label>

                        <input
                            v-model="form.unit"
                            type="text"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2"
                        />

                        <p
                            v-if="form.errors.unit"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.unit }}
                        </p>
                    </div>
                    <!-- description -->
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
                        @click="closeProductModal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Saving...' : editingProduct ? 'Update Product' : 'Add Product' }}
                    </button>
                </div>
            </form>
        </Modal>

        <DataTable
            :columns="columns"
            :rows="products.data"
            :pagination="products"
            @edit="editProduct"
            @delete="deleteProduct"
        />
    </AuthenticatedLayout>
</template>