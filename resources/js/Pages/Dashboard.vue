<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex flex-col items-center">
                        <span class="mb-6 text-lg text-gray-700">
                            Welcome to your VRG GmbH Todo Dashboard!
                        </span>
                        <Link
                            href="/todos"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded transition"
                        >
                            Manage My Todos
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
