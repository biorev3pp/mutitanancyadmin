<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
    import { computed } from '@vue/runtime-core';
    
    export default {
        components: {
            BreezeAuthenticatedLayout,
            Head
        },
        data() {
            return {
                search:''
            }
        },
        computed: {
            filteredDomains() {
                let sh = this.search;
                if(sh) {
                    return this.domains.filter((ele) => {
                        return (ele.domain.includes(sh) || ele.docroot.includes(sh))
                    })
                } else {
                    return this.domains
                }
            }
        },
        setup() {

            const domains = computed(() => usePage().props.value.domains.cpanelresult.data);
            console.log(domains)
            return {
                domains
            }
        },
        methods: {
            avtarText(val) {
                let sp = val.split(' ');
                sp = sp.map(i => i.charAt(0))
                return sp.join('').substr(0,2).toUpperCase()
            }
        }
    };
</script>

<template>
    <Head title="Domains | Biorev Superadmin" />

    <BreezeAuthenticatedLayout>
        <template #header>
            Domains
        </template>
        <div class="relative overflow-x-auto shadow-md bg-white sm:rounded-lg">
            <div class="p-4">
                <div class="flex justify-between items-center">
                    <div class="relative mt-1 leading-none">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" v-model="search" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                    </div>
                   <button type="button" class="transition duration-500 inline-flex items-center  focus:outline-none text-white bg-zinc-600 hover:bg-zinc-800 focus:ring-4 focus:ring-zinc-300 font-medium rounded-sm text-sm px-3 py-2 dark:bg-zinc-600 dark:hover:bg-zinc-700 dark:focus:ring-zinc-900">
                       <svg class="w-5 h-5 mr-1 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                       <span>Add New Domain</span>
                    </button>

                </div>
            </div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-y border-gray-200">
                    <tr>
                        <th scope="col" class="sticky px-6 py-3">
                            SNo
                        </th>
                        <th scope="col" class="sticky px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="sticky px-6 py-3">
                            Doc-root
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" v-for="(domain, index) in filteredDomains" :key="domain">
                        
                        <td class="w-4 px-6 py-3">
                            {{ index + 1 }}
                        </td>
                        
                        <td class="px-6 py-4 font-medium">
                            {{ domain.domain }}
                        </td>
                        <td class="px-6 py-4">
                            {{ domain.docroot }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </BreezeAuthenticatedLayout>
</template>
