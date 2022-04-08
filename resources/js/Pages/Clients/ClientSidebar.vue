<template>
    <div class="w-96 full-sidebar transition-all duration-500 ease-in-out absolute top-0 bg-white shadow-lg" :class="[(sidebarStatus)?'-right-96 ':'right-0 ']">
        <div class="bg-gray-600 border-b border-gray-500 py-2 px-2  tracking-wide flex justify-between items-center mb-1">
            <h5 class="pl-2 text-md font-light leading-none text-white">{{ client_title }}</h5>
            <a href="javascript:;" @click="$emit('changeSidebarStatus')" class="transition delay-300 text-gray-200 hover:text-white">
                <BiorevIcon icon="x-circle" className="w-7 h-7" />
            </a>            
        </div>
        <div class="p-3 scrollable-inner-screen">
            <form @submit.prevent="submitForm" @keydown="form.onKeydown($event)">
                <div class="mb-4">
                    <label for="name" :class="$formClasses.label">Full Name</label>
                    <input type="name" id="name" v-model="form.name" :class="(form.errors.has('name'))?$formClasses.textInputError:$formClasses.textInput" autocomplete="Off" placeholder="Enter Name" @change="generateCode()">
                    <p :class="$formClasses.errorLabel" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                </div>
                <div class="mb-4">
                    <label for="email" :class="$formClasses.label">Email</label>
                    <input type="email" id="email" v-model="form.email" :class="(form.errors.has('email'))?$formClasses.textInputError:$formClasses.textInput" placeholder="Enter Email">
                    <p :class="$formClasses.errorLabel" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                </div>
                <div class="mb-4">
                    <label for="client_code" :class="$formClasses.label">Client Code</label>
                    <input type="text" id="client_code" v-model="form.client_code" :class="$formClasses.textInput" placeholder="It Will generate Automatically" :readonly="editMode">
                </div>
                <div class="mb-4">
                    <label for="remarks" :class="$formClasses.label">Remarks</label>
                    <textarea rows="4" id="remarks" v-model="form.remarks" :class="$formClasses.textInput" placeholder="Some remarks"></textarea>
                </div>
            </form>
        </div>
        <div class="border-t border-gray-200 h-14 p-3 absolute bottom-0 right-0 w-96 flex justify-between items-center">
            <button type="button" :class="$formClasses.submitBtn" @click="submitForm()">
                <BiorevIcon :icon="client_icon" className="w-5 h-5 mx-1" />
                <span>{{client_btn}}</span>
            </button>
            <button type="button" :class="$buttonClasses.cancelBtn" @click="$emit('changeSidebarStatus')">
                <BiorevIcon icon="x" className="w-4 h-4 mx-1" />
                <span>Cancel</span>
            </button>
        </div>
    </div>
</template>

<script>
import Form from 'vform'

export default {
    components:{
        Form,
    },
    data() {
        return {
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
    props: {
        hideSidebar:Boolean,
        editMode:Boolean,
        clientData:[Object,Array],
    },
    
    computed: {
        sidebarStatus() {
            return this.hideSidebar
        },
        client_title() {
            if(this.editMode) return 'Edit Client';
            else return 'Add New Client';
        },
        client_btn() {
            if(this.editMode) return 'Update Detail';
            else return 'Add New';
        },
        client_icon() {
            if(this.editMode) return 'pencil-alt';
            else return 'plus';
        }
    },
    methods: {
        submitForm() {
            if(this.editMode) {
                this.form.put('/api/clients/'+this.form.id)
                    .then((res) => {
                        this.form.reset()
                        this.$toast.success('Client has been updated successfully')
                        this.$emit('refresh-data')
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            } else {
                this.form.post('/api/clients')
                    .then((res) => {
                        this.form.reset()
                        this.$toast.success('Client has been added successfully')
                        this.$emit('refresh-data')
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            }
        },
        generateCode() {
            let name = this.form.name;
            name = name.split(' ')[0];
            let ccode = name.charAt(0)+name.charAt(name.length/2)+name.charAt(name.length - 1);
            this.form.client_code = ccode.toUpperCase();
        }
    },
    mounted() {
        if(this.editMode) {
            this.form.fill(this.clientData)
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