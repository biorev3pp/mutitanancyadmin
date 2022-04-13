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
                apiStatuses : [],
                domainstatus : true,
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
                    client_id : '',
                    name:'anand',
                    email:'avanandverma8@gmail.com',
                    client_code:'anand',
                    remarks:'client remarks',
                    status:1,
                    packageInof : '',
                    subdomain : '',
                    status : 1,
                    notes : 'project remarks',
                    project_name : 'project 001',
                    dbNameCreated : '',
                    rootdomain : '',
                    source : '',
                    destination : '',
                })
            }
        },
        computed: {
            apiStatusList(){
                return this.apiStatuses;
            }
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
           return {
               packages
           }
        },
        methods: {
            MoveStep() {
                if(this.active_step == 1){
                    //api for client info validation
                    // this.form.post('//api/validate-client-data').then((resClientValidate) => {

                    // })
                    this.active_step = this.active_step + 1
                } else if(this.active_step == 2){
                    //check for project validation
                    this.form.post('/api/validate-project-data').then((response) => {
                        if(response.data.status == 'success'){
                            this.active_step = this.active_step + 1  
                            this.setupClientSaveClientInfo()  
                        }
                    })
                }

            },
            setupClientSaveClientInfo(){
                //1 save clien
                this.form.post('/api/save-client-info').then((resClient) => {
                    if(resClient.data.status == 'success'){
                        this.apiStatuses.push('Client profile created...')
                        //api to create project
                        this.form.client_id = resClient.data.client_id
                        this.setupClientSaveProjectInfo()
                    }else{ return false }
                })
            },
            setupClientSaveProjectInfo(){
                //2 save project
                this.form.post('/api/save-project-info').then((resProject) => {
                    if(resProject.data.status = 'success'){
                        this.apiStatuses.push('Project created...')
                        this.setupClientCreateDatabase()
                    }else{ return false }
                })
            },
            setupClientCreateDatabase(){
                //3 create database
                this.form.post('/api/create-database').then((resDatabase) => {
                    if(resDatabase.data.status == 'success'){
                        this.apiStatuses.push('Database created...')
                        this.form.dbNameCreated = resDatabase.data.dbNameCreated
                        this.form.rootdomain = resDatabase.data.rootdomain
                        this.setupClientSetPrivilegesOnDatabase()
                    }else{ return false }
                })
            },
            // setupClientUpdateLocalEnv(){
            //     //4 update local env
            //     this.form.post('/api/update-local-env').then((resUpdateLocalENV) => {
            //         if(resUpdateLocalENV.data.status == 'success'){
            //             this.apiStatuses.push('Local env updated...')
            //             this.setupClientSetPrivilegesOnDatabase()
            //         }else{ return false }
            //     })
            // },
            setupClientSetPrivilegesOnDatabase(){
                //5 set user privileges
                this.form.post('/api/set-db-privileges').then((resPrivilege) => {
                    if(resPrivilege.data.status == 'success'){
                        this.apiStatuses.push('Set privileges on database...')  
                        this.setupClientAddingSubDomain()                                                          
                    }else{ return false }
                })
            },
            setupClientAddingSubDomain(){
                //6 adding sub domain
                this.form.post('/api/adding-sub-domain').then((resAddSubDomain) => {
                    if(resAddSubDomain.data.status == 'success'){
                        this.apiStatuses.push('Added sub domain...')    
                        this.setupClientTransferingFiles()                                                                
                    }else{ return false }
                })
            },
            setupClientTransferingFiles(){
                //7 file transfer
                this.form.post('/api/transfering-files').then((resTrnasferFiles) => {
                    if(resTrnasferFiles.data.status == 'success'){
                        this.apiStatuses.push('File transfer...')
                        this.form.source = resTrnasferFiles.data.source
                        this.form.destination = resTrnasferFiles.data.destination
                        this.setupClientUpdatingEnv()
                    }else{ return false }
                })
            },
            setupClientUpdatingEnv(){
                //8 updat env server
                this.form.post('/api/updating-env').then((resUpdateENV) => {
                    if(resUpdateENV.data.status == 'success'){
                        this.apiStatuses.push('Update server env...')
                        this.setupClientUpdateDatabase()
                    }else{ return false }
                })
            },
            setupClientUpdateDatabase(){
                //9 update database
                this.form.post('/api/update-database').then((resUpdateDatabase) => {
                    if(resUpdateDatabase.data.status == 'success'){
                        this.setupClientRevertEnvUpdate()
                    }else{ return false }
                })
            },
            setupClientRevertEnvUpdate(){
                //10 rever changes in local env
                this.form.post('/api/revert-env-update').then((resRevertUpdateDatabase) => {
                    //resRevertUpdateDatabase
                })
            },
            BackStep() {
                this.active_step = this.active_step - 1
            },
            submitForm() {},
            createSubdomain(){
                var a = this.form.packageInof.split(',')
                this.form.package = a[0]
                this.form.package_id = a[1]
                this.form.subdomain = this.form.client_code.toLowerCase() + '.' + a[1]
                
            },
            submitProject(){
                if(this.editMode) {
                    this.form.post('/api/update-project-data').then((response) => {
                        if(response.data.status == 'success'){
                            this.form.reset()
                            this.$toast.success('Project updated successfully')                    
                            this.$emit('refreshSidebar')   
                        }else{
                            this.$toast.warning('Please try again')  
                        }
                    })
                }else{
                    this.form.post('/api/save-project-data').then((response) => {
                        if(response.data.status == 'success'){
                            this.form.reset()
                            this.$toast.success('Project added successfully')                    
                            this.$emit('refreshSidebar')   
                        }else{
                            this.$toast.warning('Please try again')  
                        }
                    })
                }
                
            }
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
                    <div class="project-add  mt-8 mx-24" v-else-if="active_step == 2">
                        <div class="flex flex-row">
                            <div class="mb-4 mr-3 basis-1/3">
                                <label for="product-name" :class="$formClasses.label">Project Name</label>
                                <input type="text" id="name" v-model="form.project_name" :class="(form.errors.has('name'))?$formClasses.textInputError:$formClasses.textInput" autocomplete="Off" placeholder="Enter Name" @change="generateCode()">
                                <p :class="$formClasses.errorLabel" v-if="form.errors.has('project_name')" v-html="form.errors.get('project_name')" />
                            </div>
                            <div class="mb-4 mx-3 basis-1/3">
                                <label for="dropdown-domain" :class="$formClasses.label">Packages</label>
                                <select id="dropdown-domain" :class="(form.errors.has('package'))?$formClasses.textInputError:$formClasses.textInput" aria-label="select Package" @change="createSubdomain()" v-model="form.packageInof">
                                    <option value="">select Package</option>
                                    <option v-for="pack in packages" :key="pack.id" :value="pack.id+','+pack.domain_name">{{ pack.package_name }}</option>                                
                                </select>
                                <p :class="$formClasses.errorLabel" v-if="form.errors.has('package')" v-html="form.errors.get('package')" />
                            </div>
                            <div class="mb-4 ml-3 basis-1/3">
                                <label for="client_code" :class="$formClasses.label">Client Code</label>
                                <input class="cursor-not-allowed" disabled readonly type="text" id="client_code" v-model="form.client_code" :class="$formClasses.textInput" placeholder="It Will generate Automatically">
                            </div>
                        </div>
                        <div class="flex flex-row">
                            <div class="mb-4  basis-1/3">
                                <label for="subdomain-input" :class="$formClasses.label">Sub Domain</label>
                                <div class="flex mr-3">
                                    <span class="cursor-pointer inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 rounded-l-sm border border-r-0 border-gray-300 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600" @click="submitProject">
                                        <BiorevIcon v-show="domainstatus" icon="check" className="flex-shrink-0 w-5 h-5 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" />
                                        <BiorevIcon v-show="!domainstatus" icon="x" className="flex-shrink-0 w-5 h-5 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" />
                                    </span>
                                    <input type="text" id="subdomain-input" :class="(form.errors.has('subdomain'))?$formClasses.textInputError:$formClasses.textInput" placeholder="Sub Domain" v-model="this.form.subdomain">
                                </div>
                                <p :class="$formClasses.errorLabel" v-if="form.errors.has('subdomain')" v-html="form.errors.get('subdomain')" />
                            </div>
                            <div class="mb-4 mx-3 basis-1/3">
                                <label for="dropdown-status" :class="$formClasses.label">Status</label>
                                <select id="dropdown-status" :class="(form.errors.has('status'))?$formClasses.textInputError:$formClasses.textInput" aria-label="select Package" v-model="form.status">
                                    <option value="">select</option>
                                    <option value="1" selected>Active</option>
                                    <option value="0">In-Active</option>
                                </select>
                                <p :class="$formClasses.errorLabel" v-if="form.errors.has('status')" v-html="form.errors.get('status')" />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="remarks" :class="$formClasses.label">Remarks</label>
                            <textarea rows="4" id="remarks" v-model="form.notes" :class="$formClasses.textInput" placeholder="Some remarks"></textarea>
                        </div>
                    </div>
                    <div class="log  mt-8 mx-24" v-else-if="active_step == 3">
                        <div class="border h-96 overflow-y-auto p-2 font-mono bg-gray-200 border-gray-300 text-stone-500">
                            <p v-for="(status,index) in apiStatusList" :key="'status-'+index">{{ status }}</p>
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
