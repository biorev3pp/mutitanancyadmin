<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Database | Biorev Superadmin" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Database
            </h2>
        </template>

        <!-- <div class="py-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200"> -->
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full">
                                            <thead class="border-b">
                                                <tr>
                                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">Sno.</th>
                                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">Domain</th>
                                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">Docroot</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(domain,index) in domains.cpanelresult.data" :key="index">
                                                    <td class="text-sm text-gray-900 font-medium px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ domain.domain }}</td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ domain.docroot }}</td>
                                                </tr>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div>
            </div>
        </div> -->
    </BreezeAuthenticatedLayout>
</template>
<script>
    
export default{
        name: "Domains",
        components: {
        },
        props: {
            errors: Object,
            domains : Object,
        },
        setup() {
            
        }
    }
</script>
<style scoped>

</style>