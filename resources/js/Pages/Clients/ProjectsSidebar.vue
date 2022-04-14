<template>
    <div class="w-96 full-sidebar transition-all duration-500 ease-in-out absolute top-0 bg-white shadow-lg" :class="[(sidebarStatus)?'-right-96 ':'right-0 ']">
        <div class="bg-gray-600 border-b border-gray-500 py-2 px-2  tracking-wide flex justify-between items-center mb-1">
            <h5 class="pl-2 text-md font-light leading-none text-white">{{ ptitle }}</h5>
            <a href="javascript:;" @click="$emit('changeSidebarStatus')" class="transition delay-300 text-gray-200 hover:text-white">
               <BiorevIcon icon="x-circle" className="w-7 h-7" />
            </a>            
        </div>
        <div class="p-3 scrollable-inner-screen">
            <span class="text-indigo-500">Client Code : {{ form.client_code }}</span>
                <form v-if="form.projectDataSaved == 0">
                    <div class="mb-4">
                        <label for="product-name" :class="$formClasses.label">Project Name</label>
                        <input id="product-name" type="text" :class="(form.errors.has('name'))?$formClasses.textInputError:$formClasses.textInput"
                        placeholder="Project Name" v-model="form.project_name">
                        <p :class="$formClasses.errorLabel" v-if="form.errors.has('project_name')" v-html="form.errors.get('project_name')" />
                    </div>
                    <div class="mb-4">
                        <label for="dropdown-domain" :class="$formClasses.label">Package</label>
                        <select id="dropdown-domain" :class="(form.errors.has('package'))?$formClasses.textInputError:$formClasses.textInput" aria-label="select Package" @change="createSubdomain()" v-model="form.packageInof">
                            <option value="">Select Package</option>
                            <option v-for="pack in dpackages" :key="pack.id" :value="pack.id+','+pack.domain_name">{{ pack.package_name }}</option>                                
                        </select>
                        <p :class="$formClasses.errorLabel" v-if="form.errors.has('package')" v-html="form.errors.get('package')" />
                    </div>
                    <div class="mb-4">
                            <label for="subdomain-input" :class="$formClasses.label">Sub Domain</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 rounded-l-sm border border-r-0 border-gray-300 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600 cursor-pointer" @click="submitProject">
                                <BiorevIcon v-show="domainstatus" icon="check" className="flex-shrink-0 w-5 h-5 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" />
                                <BiorevIcon v-show="!domainstatus" icon="x" className="flex-shrink-0 w-5 h-5 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" />
                            </span>
                            <input type="text" id="subdomain-input" :class="(form.errors.has('subdomain'))?$formClasses.textInputError:$formClasses.textInput" placeholder="Sub Domain" v-model="this.form.subdomain">
                        </div>
                            <p :class="$formClasses.errorLabel" v-if="form.errors.has('subdomain')" v-html="form.errors.get('subdomain')" />
                            
                    </div>
                    <div class="mb-4">
                        <label for="dropdown-status" :class="$formClasses.label">Status</label>
                        <select id="dropdown-status" :class="(form.errors.has('status'))?$formClasses.textInputError:$formClasses.textInput"  v-model="form.status">
                            <option value="">Select Status</option>
                            <option value="1" selected>Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <p :class="$formClasses.errorLabel" v-if="form.errors.has('status')" v-html="form.errors.get('status')" />
                    </div>
                    <div class="form-group mb-6">
                        <label for="message" :class="$formClasses.label">Notes</label>
                        <div class="flex">
                            <textarea id="message" rows="4" :class="$formClasses.textInput" placeholder="Leave a note..." v-model="form.notes"></textarea>
                        </div>
                    </div>                    
                </form>
                <div class="log  mt-8" v-else-if="form.projectDataSaved == 1">
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
        </div>

        <div class="border-t border-gray-200 h-14 p-3 absolute bottom-0 right-0 w-96 flex justify-between items-center">
            <button :disabled="form.addNewProject" @click="submitProject" type="button"  :class="$formClasses.submitBtn">
                <svg class="w-5 h-5 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                <span>{{ ptitle }}</span>
            </button>
            <button type="button" :class="$buttonClasses.cancelBtn" @click="$emit('changeSidebarStatus')">
                <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span>Cancel</span>
            </button>
        </div>
    </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform';
import Datepicker from 'vue3-datepicker';
import { ref } from 'vue'

export default {
    components : {Datepicker},
    data() {
        return {
            apiStatuses : [],
            loader: false,
            note : '',
            domainstatus : true,
            form : new Form({
                id : '',
                client_id : this.client_id,
                client_code : this.clientCode,
                // for client
                name:'', 
                email:'',
                remarks:'',
                status:1,

                packageInof : '',
                project_name : '',
                subdomain : '',
                packageInof : '',
                package : '',
                package_id : '',
                notes : '',
                addNewProject : false,
                dbNameCreated : '',
                rootdomain : '',
                source : '',
                destination : '',
                setup_date : ref(new Date()),
                projectDataSaved : 0
            })
        }
    },
    props: {
        hideSidebar:Boolean,
        editMode:Boolean,
        projectData : [Array, Object],
        client_id : '',
        clientCode : {
            type : String,
            required : true,
            default : 'ABC'
        },
        packages : Array ,
        errors : Object,
    },
    created(){
        
    },
    computed: {
        apiStatusList(){
            return this.apiStatuses;
        },
        ptitle(){
            if(this.editMode) return 'Edit Project';
            else return 'Add New Project';
        },
        sidebarStatus() {
            return this.hideSidebar
        },
        dpackages(){
            return this.packages
        }
    },
    methods: {
        createSubdomain(){
            var a = this.form.packageInof.split(',')
            this.form.package = a[0]
            this.form.package_id = a[1]
            this.form.subdomain = this.clientCode.toLowerCase() + '.' + a[1]
            this.form.addNewProject = false
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
                //validate project information
                this.form.post('/api/validate-project-data').then((response) => {
                    if(response.data.status == 'success'){
                        this.form.projectDataSaved = true
                        this.loader = true  
                        this.setupClientSaveProjectInfo()
                    }
                })
            }            
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
    },
    watch: {
        
    },
    mounted() {
        if(this.editMode) {
            this.form.id = this.projectData.id
            this.form.project_name = this.projectData.module_name
            this.form.subdomain = this.projectData.subdomain
            var curPackage = this.packages.filter((element) => {
                if(element.id == this.projectData.package_id){
                    return element
                }
            })
            this.form.packageInof = this.projectData.package_id+','+curPackage[0]['domain_name']
            this.form.package = this.projectData.package_id
            this.form.package_id = curPackage[0]['domain_name']
            this.form.subdomain = this.projectData.subdomain
            this.form.notes = this.projectData.notes
            this.form.status = this.projectData.status
            // this.form.setup_date = this.projectData.setup_date
            
        }
    }

}
</script>

<style scoped>

.full-sidebar{
    height: calc(100vh - 59px);
}
.scrollable-inner-screen{
    height: calc(100vh - 250px);
    overflow-y:auto;
}

</style>