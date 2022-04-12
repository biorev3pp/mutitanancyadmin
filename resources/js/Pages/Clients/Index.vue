<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import ClientSidebar from './ClientSidebar.vue';
    import { usePage } from '@inertiajs/inertia-vue3';
    import { computed } from '@vue/runtime-core';
    import { Inertia } from '@inertiajs/inertia';

    const { base64encode, base64decode } = require('nodejs-base64');
    
    export default {
        components: {
            BreezeAuthenticatedLayout,
            ClientSidebar,
        },
        data() {
            return {
                search:'',
                rerenderPopup: false,
                sidebar : true,
                editmode: false,
                active_client:{},
            }
        },
        computed: {
            filteredClients() {
                let sh = this.search;
                if(sh) {
                    return this.clients.filter((ele) => {
                        return (ele.name.includes(sh) || ele.client_code.includes(sh) || ele.email.includes(sh))
                    })
                } else {
                    return this.clients
                }
            }
        },
        setup() {
            const clients = computed(() => usePage().props.value.clients);
            return {
                clients,
            }
        },
        methods: {
            avtarText(val) {
                let sp = val.split(' ');
                sp = sp.map(i => i.charAt(0))
                return sp.join('').substr(0,2).toUpperCase()
            },
            jstobase64(str){                
                return base64encode(str)
            },
            changeSidebar() {
                this.sidebar = !this.sidebar
                this.editmode = false
                this.rerenderPopup = false
            },
            refreshData() {
                Inertia.reload()
                this.changeSidebar()
            }
        }
    };
</script>

<template>
    <Head title="Clients | Biorev Superadmin" />

    <BreezeAuthenticatedLayout>
        <template #header>
            Clients
        </template>
        <div class="relative overflow-hidden shadow-md bg-white sm:rounded-lg">
            <div class="p-4">
                <div class="flex justify-between items-center">
                    <div class="relative mt-1 leading-none">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <BiorevIcon icon="search" className="w-5 h-5 text-gray-500 dark:text-gray-400" />
                        </div>
                        <input type="text" v-model="search" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for client">
                    </div>
                   <button type="button" :class="$buttonClasses.addBtn" @click="rerenderPopup = true; sidebar = !sidebar">
                       <BiorevIcon icon="plus" className="w-5 h-5 mr-1 ml-1 text-white" />
                       <span>Add New Client</span>
                    </button>

                </div>
            </div>
            <div class="w-full overflow-auto" style="max-height: calc(100vh - 200px);">
                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400 border-separate" style="border-spacing:0">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-y border-gray-200 border-separate">
                        <tr>
                            <th scope="col" class="top-0 bg-gray-100 border-y border-gray-200 sticky px-4 py-3">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="top-0 bg-gray-100 border-y border-gray-200 sticky px-4 py-3">
                                Client Name
                            </th>
                           <th scope="col" class="top-0 bg-gray-100 border-y border-gray-200 sticky px-4 py-3">
                                Client Email
                            </th>
                            <th scope="col" class="top-0 bg-gray-100 border-y border-gray-200 sticky px-4 py-3">
                                Projects
                            </th>
                            <th scope="col" class="top-0 bg-gray-100 border-y border-gray-200 sticky px-4 py-3">
                                Remarks
                            </th>
                            <th scope="col" class="top-0 bg-gray-100 border-y border-gray-200 sticky px-4 py-3">
                                Status
                            </th>
                            <th scope="col" class="top-0 bg-gray-100 border-y border-gray-200 sticky px-4 py-3 text-right">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b odd:bg-white even:bg-gray-100 odd:dark:bg-gray-800 even:dark:bg-gray-700 dark:border-gray-700 hover:bg-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600" v-for="client in filteredClients" :key="client.id">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium dark:text-white whitespace-nowrap capitalize">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="p-2 w-8 h-8 rounded-full bg-indigo-200 text-indigo-800">
                                            {{ avtarText(client.name) }}
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h6 class=" text-gray-900"><Link :href="route('client-projects',  jstobase64(client.client_code))">{{ client.name }}</Link></h6>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400 tracking-wide">
                                            <small class="font-semibold"> CLIENT CODE: <span class="text-indigo-700">{{ client.client_code }}</span> </small>
                                        </p>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 font-medium">
                                {{ client.email }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block py-1 px-2 leading-none text-center whitespace-nowrap align-baseline font-normal bg-indigo-600 text-white rounded-sm ml-2">
                                    <Link :href="route('client-projects',  jstobase64(client.client_code))">
                                        {{ client.project_count }}
                                    </Link>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                {{ client.remarks }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-3 py-1 rounded dark:bg-green-200 border dark:text-green-900 border-green-300" v-if="client.status == 1">Active</span>
                                <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-3 py-1 rounded dark:bg-red-200 dark:text-red-900 border border-red-300" v-else>Deactive</span>
                                
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button type="button" :class="$buttonClasses.tableEditBtn" @click="rerenderPopup = true; sidebar = !sidebar; editmode = true; active_client = client;">
                                    <BiorevIcon icon="pencil-alt" className="w-4 h-4 mr-1 ml-1 text-dark" />
                                    <span>Edit</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="rerenderPopup">
            <ClientSidebar @refresh-data="refreshData()" @change-sidebar-status="changeSidebar()" :hide-sidebar="sidebar" :edit-mode="editmode" :client-data="active_client" />
        </div>
    </BreezeAuthenticatedLayout>
</template>
