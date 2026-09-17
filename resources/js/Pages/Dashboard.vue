<template>
    <div class="flex min-h-screen flex-col items-center justify-center bg-gray-100">
        <h1 class="text-3xl font-bold">
            TindahanOS Dashboard
        </h1>

        <p class="mt-2 text-gray-600">
            You are logged in.
        </p>

        <form method="POST" action="/logout" class="mt-6">
            <button
                type="submit"
                class="rounded-lg bg-red-600 px-4 py-2 font-semibold text-white hover:bg-red-700"
            >
                Logout
            </button>
        </form>
    </div>
</template>