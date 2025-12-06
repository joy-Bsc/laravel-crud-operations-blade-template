<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>
<template>
    <Head title="About" />
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <h1 class="text-6xl font-bold text-gray-900 dark:text-white">About Us</h1>
    </div>
</template>