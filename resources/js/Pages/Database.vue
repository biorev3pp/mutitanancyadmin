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
        <!-- <div class="w-full sm:w-9/12 lg:w-8/12 px-4 sm:pr-10 lg:pr-4"> -->
            <div class="mb-12">
                <main>
                    <section class="my-1 mx-1">
                        <div class="bg-white border-t border-l border-r rounded-5 ">
                            <div class="p-4">
                                <div class="flex flex-col">
                                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="overflow-hidden">
                                                <table class="min-w-full table-auto">
                                                    <thead class="border-b">
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Sno</th>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Name</th>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Size(MB)</th>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">User(s)</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(database,index) in databases.cpanelresult.data" :key="index" class="border-b">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ index+1 }}</td>
                                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ database.db }}</td>
                                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ parseFloat(database.size/(1024*1024)).toFixed(2) }}</td>
                                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ database.userlist[0].user }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        <!-- </div> -->
    </BreezeAuthenticatedLayout>
</template>
<script>
    import {usePage} from "@inertiajs/inertia-vue3";
    import {Inertia} from "@inertiajs/inertia";
    import {computed, inject} from "vue";
export default{
        name: "Database",
        components: {
        },
        props: {
            errors: Object,
            databases : Object,
        },
        setup() {
            
        }
    }
</script>
<style scoped>
.tabel-head{
    font-size: 16px;
    color: black;
}
</style>