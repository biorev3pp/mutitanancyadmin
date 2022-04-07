<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, usePage } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/runtime-core';
const domains = computed(() => { return usePage().props.value.domains })
</script>

<template>
    <Head title="Setup New Client | Biorev Superadmin" />

    <BreezeAuthenticatedLayout>
        <template #header>
            Setup New Client
        </template>

        <div class="p-2.5 bg-white sm:rounded-md shadow-sm overflow-hidden">
            
        </div>
    </BreezeAuthenticatedLayout>
</template>
