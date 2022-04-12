<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { usePage } from '@inertiajs/inertia-vue3';
    import { computed } from '@vue/runtime-core';
    import { Inertia } from '@inertiajs/inertia';
    import Form from 'vform'
    export default {
        components: {
            BreezeAuthenticatedLayout,
            Form
        },
        data() {
            return {
                active_step: 1,
                activeClass:'flex z-10 justify-center items-center w-10 h-10 bg-blue-200 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0',
                completClass:'flex z-10 justify-center items-center w-10 h-10 bg-green-200 rounded-full ring-0 ring-white dark:bg-green-900 sm:ring-8 dark:ring-gray-900 shrink-0',
                pendingClass:'flex z-10 justify-center items-center w-10 h-10 bg-gray-200 rounded-full ring-0 ring-white dark:bg-gray-900 sm:ring-8 dark:ring-gray-900 shrink-0',
                activeClassIcon:'w-6 h-6 text-blue-600 dark:text-blue-300',
                completClassIcon:'w-6 h-6 text-green-600 dark:text-green-300',
                pendingClassIcon:'w-6 h-6 text-gray-600 dark:text-gray-300',
                activeClassTxt:'text-sm font-semibold text-blue-600 dark:text-white',
                completClassTxt:'text-sm font-semibold text-green-600 dark:text-white',
                pendingClassTxt:'text-sm font-semibold text-gray-600 dark:text-white',
                form: new Form({
                    id:'',
                    name:'',
                    email:'',
                    client_code:'',
                    remarks:'',
                    status:1
                })
            }
        },
        computed: {
            
        },
        setup() {
            // const projects = computed(() => usePage().props.value.projects);
            // const client = computed(() => usePage().props.value.client)
            // const domain_packages = computed(() => usePage().props.value.packages)
            // return {
            //     projects,
            //     client,
            //     domain_packages,
            // }
           const packages = computed(() => usePage().props.value.packages);
           console.log(packages)
           return {
               packages
           }
        },
        methods: {
            MoveStep() {
                this.active_step = this.active_step + 1
            },
            BackStep() {
                this.active_step = this.active_step - 1
            },
            submitForm() {}
        }
    };
</script>


<template>
    <Head title="Setup New Client | Biorev Superadmin" />
    <BreezeAuthenticatedLayout>
        <template #header>
            Setup New Client
        </template>

        <div class="py-5 px-3 bg-white sm:rounded-md shadow-sm overflow-hidden">
            <div class="items-center flex flex-row mx-24">
                <div class="relative mb-6 sm:mb-0 basis-1/3">
                    <div class="flex items-center">
                        <div :class="[(active_step == 1)?activeClass:((active_step >= 2)?completClass:pendingClass)]">
                            <BiorevIcon icon="user" :className="[(active_step == 1)?activeClassIcon:((active_step >= 2)?completClassIcon:pendingClassIcon)]" />
                        </div>
                        <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                    </div>
                    <div class="-mt-4 ml-12 sm:pr-8 block">
                        <h3 :class="[(active_step == 1)?activeClassTxt:((active_step >= 2)?completClassTxt:pendingClassTxt)]">Create Client Profile</h3>
                    </div>
                </div>
                <div class="relative mb-6 sm:mb-0 basis-1/3">
                    <div class="flex items-center">
                        <div :class="[(active_step == 2)?activeClass:((active_step > 2)?completClass:pendingClass)]">
                            <BiorevIcon icon="cake" :className="[(active_step == 2)?activeClassIcon:((active_step > 2)?completClassIcon:pendingClassIcon)]" />
                        </div>
                        <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                    </div>
                    <div class="-mt-4 ml-12 sm:pr-8 block">
                        <h3 :class="[(active_step == 2)?activeClassTxt:((active_step > 2)?completClassTxt:pendingClassTxt)]">Create project</h3>
                    </div>
                </div>
                <div class="relative mb-6 sm:mb-0 basis-1/3">
                    <div class="flex items-center">
                        <div :class="[(active_step == 3)?activeClass:((active_step > 3)?completClass:pendingClass)]">
                            <BiorevIcon icon="badgeCheck" :className="[(active_step == 3)?activeClassIcon:((active_step > 3)?completClassIcon:pendingClassIcon)]" />
                        </div>
                        <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                    </div>
                    <div class="-mt-4 ml-12 sm:pr-8 block">
                        <h3 :class="[(active_step == 3)?activeClassTxt:((active_step > 3)?completClassTxt:pendingClassTxt)]">Done</h3>
                    </div>
                </div>
            </div>
            <div class="wizard-container overflow-y-auto border-b border-gray-300 my-4" style="height:calc(100vh - 280px)">
                <form @submit.prevent="submitForm" @keydown="form.onKeydown($event)">
                    <div class="client-add mt-8 mx-24" v-if="active_step == 1">
                        <div class="flex flex-row">
                            <div class="mb-4 mr-3 basis-1/3">
                                <label for="name" :class="$formClasses.label">Full Name</label>
                                <input type="name" id="name" v-model="form.name" :class="(form.errors.has('name'))?$formClasses.textInputError:$formClasses.textInput" autocomplete="Off" placeholder="Enter Name" @change="generateCode()">
                                <p :class="$formClasses.errorLabel" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                            </div>
                            <div class="mb-4 mx-3 basis-1/3">hu
                                <label for="email" :class="$formClasses.label">Email</label>
                                <input type="email" id="email" v-model="form.email" :class="(form.errors.has('email'))?$formClasses.textInputError:$formClasses.textInput" placeholder="Enter Email">
                                <p :class="$formClasses.errorLabel" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                            </div>
                            <div class="mb-4 ml-3 basis-1/3">
                                <label for="client_code" :class="$formClasses.label">Client Code</label>
                                <input type="text" id="client_code" v-model="form.client_code" :class="$formClasses.textInput" placeholder="It Will generate Automatically" :readonly="editMode">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="remarks" :class="$formClasses.label">Remarks</label>
                            <textarea rows="4" id="remarks" v-model="form.remarks" :class="$formClasses.textInput" placeholder="Some remarks"></textarea>
                        </div>
                    </div>
                    <div class="project-add  mt-8 mx-24" v-else-if="active_step == 2">
                        <div class="flex flex-row">
                            <div class="mb-4 mr-3 basis-1/3">
                                <label for="name" :class="$formClasses.label">Project Name</label>
                                <input type="name" id="name" v-model="form.name" :class="(form.errors.has('name'))?$formClasses.textInputError:$formClasses.textInput" autocomplete="Off" placeholder="Enter Name" @change="generateCode()">
                                <p :class="$formClasses.errorLabel" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                            </div>
                            <div class="mb-4 mx-3 basis-1/3">
                                <label for="email" :class="$formClasses.label">Email</label>
                                <input type="email" id="email" v-model="form.email" :class="(form.errors.has('email'))?$formClasses.textInputError:$formClasses.textInput" placeholder="Enter Email">
                                <p :class="$formClasses.errorLabel" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                            </div>
                            <div class="mb-4 ml-3 basis-1/3">
                                <label for="client_code" :class="$formClasses.label">Client Code</label>
                                <input type="text" id="client_code" v-model="form.client_code" :class="$formClasses.textInput" placeholder="It Will generate Automatically" :readonly="editMode">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="remarks" :class="$formClasses.label">Remarks</label>
                            <textarea rows="4" id="remarks" v-model="form.remarks" :class="$formClasses.textInput" placeholder="Some remarks"></textarea>
                        </div>
                    </div>
                    <div class="log  mt-8 mx-24" v-else-if="active_step == 3">
                        <div class="border h-96 overflow-y-auto p-2 font-mono bg-gray-200 border-gray-300 text-stone-500">
                            <p>Client profile created...</p>
                            <p>New project created...</p>
                        </div>
                    </div>
                    <div class="text-center" v-else>
                        <p class="p-4"> Please wait...</p>
                    </div>
                </form>
            </div>
            <div class="wizard-actions  mx-24">
                <div class="flex justify-between ...">
                    <div>
                        <button type="button" :class="$buttonClasses.cancelBtn" @click="BackStep" v-if="active_step > 1">
                            <BiorevIcon icon="ArrowNarrowLeft" className="w-4 h-4 mx-1" />
                            Go Back
                        </button>
                    </div>
                    <div> 
                        <button type="button" :class="$formClasses.submitBtn" @click="MoveStep" v-if="active_step <= 2">
                            Next <BiorevIcon icon="ArrowNarrowRight" className="w-4 h-4 mx-1" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
