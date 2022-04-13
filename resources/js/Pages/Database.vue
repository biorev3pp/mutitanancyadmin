<template>
    <Head title="Database | Biorev Superadmin" />

    <BreezeAuthenticatedLayout>
        <template #header>
            Database List
        </template>
            <div class="relative overflow-x-auto shadow-md bg-white sm:rounded-lg">
                <div class="w-full overflow-auto" style="max-height: calc(100vh - 120px);">
                    <table class="w-full text-sm text-left text-gray-800 dark:text-gray-400 border-separate" style="border-spacing:0">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400 border-y border-gray-200 border-separate">
                            <th scope="col" class="top-0 bg-gray-100 border-y border-l border-gray-200 sticky px-6 py-3">Sno</th>
                            <th scope="col" class="top-0 bg-gray-100 border-y border-gray-200 sticky px-6 py-3">Name</th>
                            <th scope="col" class="top-0 bg-gray-100 border-y border-gray-200 sticky px-6 py-3">Size(MB)</th>
                            <th scope="col" class="top-0 bg-gray-100 border-y border-gray-200 sticky px-6 py-3">User(s)</th>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" v-for="(database,index) in databases.cpanelresult.data" :key="index">
                                <td class="px-6 py-4 whitespace-nowrap">{{ index+1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ database.db }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ parseFloat(database.size/(1024*1024)).toFixed(2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ database.userlist[0].user }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>                                            
            </div>
    </BreezeAuthenticatedLayout>
</template>
<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';

    export default{
        name: "Database",
        components: {
            BreezeAuthenticatedLayout
        },
        props: {
            errors: Object,
            databases : Object,
        },
        setup() {
            
        }
    }
</script>