<template>
    <div class="w-96 full-sidebar transition-all duration-500 ease-in-out absolute top-0 bg-white shadow-lg" :class="[(sidebarStatus)?'-right-96 ':'right-0 ']">
        <div class="bg-gray-600 border-b border-gray-500 py-2 px-2  tracking-wide flex justify-between items-center mb-1">
            <h5 class="pl-2 text-md font-light leading-none text-white">{{ ptitle }}</h5>
            <a href="javascript:;" @click="$emit('changeSidebarStatus')" class="transition delay-300 text-gray-200 hover:text-white">
               <BiorevIcon icon="x-circle" className="w-7 h-7" />
            </a>            
        </div>
        <div class="p-3 scrollable-inner-screen">
            <span class="text-indigo-500 ">Client Code : {{ form.client_code }}</span>
                <form>
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
                    <!-- <div class="mb-4">
                        <label for="setup-date" :class="$formClasses.label">Setup Date</label>
                        <datepicker
                            :class="(form.errors.has('name'))?$formClasses.textInputError:$formClasses.textInput"
                            id="setup-date"
                            :lowerLimit="new Date()"
                            v-model="form.setup_date"
                        />
                        <p :class="$formClasses.errorLabel" v-if="form.errors.has('setup_date')" v-html="form.errors.get('setup_date')" />
                    </div> -->
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
            note : '',
            domainstatus : true,
            form : new Form({
                id : '',
                client_id : this.client_id,
                client_code : this.clientCode,
                project_name : '',
                subdomain : '',
                packageInof : '',
                package : '',
                package_id : '',
                notes : '',
                addNewProject : false,
                status : '',
                setup_date : ref(new Date()),
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