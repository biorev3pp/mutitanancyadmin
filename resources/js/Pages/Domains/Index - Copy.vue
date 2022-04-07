<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, usePage } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/runtime-core';
const domains = computed(() => { return usePage().props.value.domains })
</script>

<template>
    <Head title="Domains | Biorev Superadmin" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Domains
            </h2>
        </template>

        <div class="p-2.5 bg-white sm:rounded-md shadow-sm overflow-hidden">
            {{ JSON.stringify(domains) }}
        </div>
    </BreezeAuthenticatedLayout>
</template>
