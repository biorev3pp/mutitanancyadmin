<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
export default{
        name: "Server Details",
        components: {
            BreezeAuthenticatedLayout
        },
        props: {
            errors: Object,
            response : Object,
        },
        computed: {
            service_data() {
                return this.response.data.filter((ele) => { return (ele.type == 'service') })
            },
            device_data() {
                return this.response.data.filter((ele) => { return (ele.type == 'device') })
            },
            matric_data() {
                return this.response.data.filter((ele) => { return (ele.type == 'metric') })
            }
        },
        setup() {
            
        }
    }
</script>

<template>
    <Head title="Server | Biorev Superadmin" />

    <BreezeAuthenticatedLayout>
        <template #header>
            Server Status
        </template>

        <div>
            <div class="mx-3 my-3 p-4 bg-white rounded-lg border shadow-md dark:bg-gray-800 dark:border-gray-700 bg-yellow-50 ">
                <h5 :class="$cardClasses.cardTitle" class="text-yellow-800">
                    Server Warning
                </h5>
                <div :class="$cardClasses.cardBody">
                    <p class="text-sm font-normal text-yellow-800 dark:text-gray-400" v-if="response.warning">
                        {{ response.warning }}
                    </p>
                    <p class="text-sm font-medium text-yellow-900 dark:text-gray-400" v-else>
                        Server is working smoothly. No warning found.
                    </p>
                </div>
            </div>
            <div :class="$cardClasses.card" class="bg-red-50">
                <h5 :class="$cardClasses.cardTitle" class="text-red-800">
                    Server Errors
                </h5>
                <div :class="$cardClasses.cardBody">
                    <p class="text-sm font-normal text-red-800 dark:text-gray-400" v-if="response.warning">
                        {{ response.error }}
                    </p>
                    <p class="text-sm font-medium text-red-900 dark:text-gray-400" v-else>
                        Server is working smoothly. No error found.
                    </p>
                </div>
            </div>
            <div class="flex w-full items-stretch">
                <div :class="$cardClasses.card" class="w-1/3">
                    <h5 :class="$cardClasses.cardTitle">
                        Service Details
                    </h5>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <li class="py-2" v-for="sr in service_data" :key="sr">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white uppercase ">
                                            {{ sr.name.replace('_', ' ').replace('_', ' ') }}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                         {{ sr.value }}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div :class="$cardClasses.card" class="w-1/3 self-start">
                    <h5 :class="$cardClasses.cardTitle">
                        Disc Details
                    </h5>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <li class="py-2" v-for="sr in device_data" :key="sr">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ sr.name }}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                         {{ sr.value }}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div :class="$cardClasses.card" class="w-1/3 self-start">
                    <h5 :class="$cardClasses.cardTitle">
                        Server Matric
                    </h5>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <li class="py-2" v-for="sr in matric_data" :key="sr">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ sr.name }}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                         {{ sr.value }}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
            <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Value</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tr v-for="(rd, rk) in response.data" :key="rk">
                            <th>{{rd.type}}</th>
                            <td>{{rd.name}}</td>
                            <td>{{rd.value}}</td>
                            <td>{{rd.status}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> -->
    </BreezeAuthenticatedLayout>
    
</template>
