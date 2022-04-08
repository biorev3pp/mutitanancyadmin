<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, usePage } from '@inertiajs/inertia-vue3';
import {computed, inject, reactive} from "vue";
import { Inertia } from '@inertiajs/inertia';

    export default{
        name: "Clients",
        data() {
            return {
                client_name : '',
                status : '',
                id : '',
            }
        },
        components: {
            BreezeAuthenticatedLayout, Head,
        },
        props: {
            errors: Object,
            // clients : Object,
        },
        setup() {
            const form = reactive({
                id: null,
                status: null,
                client_name : null,
            })
            const clients = computed(() => usePage().props.value.clients);
            return {
                clients
            
            }
        },
        methods:{
            showModel(client){
                form.client_name = client.name
                form.status = client.status
                form.id = client.id
                document.getElementById("staticBackdrop").classList.remove("hidden")
            },
            hideModel(){
                // this.client_name = ''
                // this.status = ''
                // this.id = ''
                document.getElementById("staticBackdrop").classList.add("hidden")
            },
            updateStatus(){
                console.log(this.client_name, this.id, this.status)
                this.form.post('/api/update-client-status').then((response) => {
                    
                })
            }
        }
        
    }
</script>

<template>
    <Head title="Clients | Biorev Superadmin" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clients
            </h2>
        </template>

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
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Code</th>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Name</th>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Email</th>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Remarks</th>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Status</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(client,index) in clients.data" :key="index" class="border-b">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ index+1 }}</td>
                                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ client.client_code }}</td>
                                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ client.name }}</td>
                                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ client.email }}</td>
                                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ client.remarks }}</td>
                                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                                <button type="button" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" data-bs-toggle="modal" data-bs-target="#staticBackdrop" v-if="client.status == 1" @click="showModel(client)">Active</button>
                                                                <button type="button" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" data-bs-toggle="modal" data-bs-target="#staticBackdrop" v-else @click="showModel(client)">In-Active</button>
                                                            </td>
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
            <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-y-auto custom-model custom-model"  
                    id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                        <div
                            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                            <form @submit.prevent="submit">
                                <input type="text" v-model="form.id" />
                                <div
                                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">
                                        Clients : {{ client_name }}
                                    </h5>
                                    <button type="button"
                                        class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body relative p-4">
                                    <div class="flex justify-center">
                                        <div class="mb-3 xl:w-96">
                                            <select class="form-select appearance-none
                                            block
                                            w-full
                                            px-3
                                            py-1.5
                                            text-base
                                            font-normal
                                            text-gray-700
                                            bg-white bg-clip-padding bg-no-repeat
                                            border border-solid border-gray-300
                                            rounded
                                            transition
                                            ease-in-out
                                            m-0
                                            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example" v-model="form.status" name="status">
                                                <option selected>Select Status</option>
                                                <option value="1" v-if="status == 1" selected>Active</option>
                                                <option value="1" v-else>Active</option>
                                                <option value="0" v-if="status == 0" selected>In-Active</option>                                            
                                                <option value="0" v-else>In-Active</option>                                            
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                                    <button type="button"
                                        class="inline-block px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
                                        data-bs-dismiss="modal" @click="hideModel">Close</button>
                                    <button type="submit"
                                        class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1" >Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        <!-- </div> -->
    </BreezeAuthenticatedLayout>
</template>
