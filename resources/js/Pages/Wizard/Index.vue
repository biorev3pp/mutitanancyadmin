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
                cstatus: false,
                loader: false,
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
                    name:'',
                    email:'',
                    client_code:'',
                    remarks:'',
                    status:1,
                    packageInof : '',
                    subdomain : '',
                    status : 1,
                    notes : '',
                    project_name : '',
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
           const packages = computed(() => usePage().props.value.packages);
           return {
               packages
           }
        },
        methods: {
            MoveStep() {
                if(this.active_step == 1){
                    this.form.post('/api/validate-client-data').then((res) => {
                        this.active_step = this.active_step + 1;
                    })
                } else if(this.active_step == 2){
                    this.form.post('/api/validate-project-data').then((response) => {
                        if(response.data.status == 'success'){
                            this.active_step = this.active_step + 1;
                            this.loader = true
                            this.setupClientSaveClientInfo()  
                        }
                    })
                }

            },
            setupClientSaveClientInfo(){
                this.form.post('/api/save-client-info').then((resClient) => {
                    if(resClient.data.status == 'success'){
                        this.apiStatuses.push('Client profile created...')
                        this.apiStatuses.push('settings project...')
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
                        this.apiStatuses.push('creating database...')
                        this.setupClientCreateDatabase()
                    }else{ return false }
                })
            },
            setupClientCreateDatabase(){
                //3 create database
                this.form.post('/api/create-database').then((resDatabase) => {
                    if(resDatabase.data.status == 'success'){
                        this.apiStatuses.push('Database created...')
                        this.apiStatuses.push('Setting Database permissions...')
                        this.form.dbNameCreated = resDatabase.data.dbNameCreated
                        this.form.rootdomain = resDatabase.data.rootdomain
                        this.setupClientSetPrivilegesOnDatabase()
                    }else{ return false }
                })
            },
            setupClientSetPrivilegesOnDatabase(){
                //5 set user privileges
                this.form.post('/api/set-db-privileges').then((resPrivilege) => {
                    if(resPrivilege.data.status == 'success'){
                        this.apiStatuses.push('Privileges setup done for database...')
                        this.apiStatuses.push('Creating subdomain...')
                        this.setupClientAddingSubDomain()                                                          
                    }else{ return false }
                })
            },
            setupClientAddingSubDomain(){
                //6 adding sub domain
                this.form.post('/api/adding-sub-domain').then((resAddSubDomain) => {
                    if(resAddSubDomain.data.status == 'success'){
                        this.apiStatuses.push('Subdomain created...')    
                        this.apiStatuses.push('Installing SSL on this subdomain ...')
                        this.setupClientTransferingFiles()                                                                
                    }else{ return false }
                })
            },
            setupClientTransferingFiles(){
                //7 file transfer
                this.apiStatuses.push('SSL installed...')
                this.apiStatuses.push('Setting the package with respective files...')
                this.form.post('/api/transfering-files').then((resTrnasferFiles) => {
                    if(resTrnasferFiles.data.status == 'success'){
                        this.apiStatuses.push('Files setup done...')
                        this.apiStatuses.push('Configuring database connection...')
                        this.form.source = resTrnasferFiles.data.source
                        this.form.destination = resTrnasferFiles.data.destination
                        this.setupClientUpdateEnv()
                    }else{ return false }
                })
            },            
            setupClientUpdateEnv(){
                //9 update database
                this.form.post('/api/updating-env').then((resUpdateDatabase) => {
                    if(resUpdateDatabase.data.status == 'success'){
                        this.apiStatuses.push('Database Configurtion is done...')
                        this.apiStatuses.push('Setting up database connection...')
                        this.setupClientUpdateDatabase()
                    }else{ return false }
                })
            },
            setupClientUpdateDatabase(){
                //9 update database
                this.form.post('/api/update-database').then((resUpdateDatabase) => {
                    if(resUpdateDatabase.data.status == 'success'){
                        this.apiStatuses.push('Database connecton is done...')
                        this.apiStatuses.push('Doing final check...')
                        this.apiStatuses.push('Subdomain id active...')
                        this.apiStatuses.push('Bingo!! Everything is done...')
                        this.apiStatuses.push('Please check SSL status in Domain section. It usually takes 12-24 hours to activate SSL.')
                        this.loader = false
                        this.cstatus = true
                    }else{ return false }
                })
            },
            
            BackStep() {
                this.active_step = this.active_step - 1
            },
            restart() {
                this.cstatus = false
                this.form.reset()
                this.active_step = 1
                Inertia.reload()
            },
            generateCode() {
                let name = this.form.name;
                name = name.split(' ')[0];
                let ccode = name.charAt(0)+name.charAt(name.length/2)+name.charAt(name.length - 1);
                this.form.client_code = ccode.toUpperCase();
            },
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
                                <p :class="$formClasses.errorLabel" v-if="form.errors.has('client_code')" v-html="form.errors.get('client_code')" />
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
                                <input type="text" id="name" v-model="form.project_name" :class="(form.errors.has('name'))?$formClasses.textInputError:$formClasses.textInput" autocomplete="Off" placeholder="Enter Name">
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
                            <span class="mt-2" v-if="loader">
                            <svg role="status" class="mr-2 w-8 h-8 text-red-200 animate-spin dark:text-red-600 fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                        </span>
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
                        <button type="button" :class="$buttonClasses.cancelBtn" @click="BackStep" v-if="(active_step > 1) && (cstatus == false)">
                            <BiorevIcon icon="ArrowNarrowLeft" className="w-4 h-4 mx-1" />
                            Go Back
                        </button>
                    </div>
                    <div> 
                        <button type="button" :class="$formClasses.submitBtn" @click="MoveStep" v-if="active_step <= 2">
                            Next <BiorevIcon icon="ArrowNarrowRight" className="w-4 h-4 mx-1" />
                        </button>
                        <button type="button" :class="$formClasses.submitBtn" @click="restart" v-if="cstatus">
                            <BiorevIcon icon="plus" className="w-4 h-4 mx-1" /> Create new Client 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
