<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';

</script>

<template>
    <Head title="Server | Biorev Superadmin" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Server
            </h2>
        </template>

        <div class="py-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Server Details
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
    
</template>
