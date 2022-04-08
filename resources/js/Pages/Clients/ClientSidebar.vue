<template>
    <div class="w-96 full-sidebar transition-all duration-500 ease-in-out absolute top-0 bg-white shadow-lg" :class="[(sidebarStatus)?'-right-96 ':'right-0 ']">
        <div class="bg-gray-600 border-b border-gray-500 py-2 px-2  tracking-wide flex justify-between items-center mb-1">
            <h5 class="pl-2 text-md font-light leading-none text-white">Add New Client</h5>
            <a href="javascript:;" @click="$emit('changeSidebarStatus')" class="transition delay-300 text-gray-200 hover:text-white">
                <BiorevIcon icon="x-circle" className="w-7 h-7" />
            </a>            
        </div>
        <div class="p-3 scrollable-inner-screen">
            Content here
        </div>
        <div class="border-t border-gray-200 h-14 p-3 absolute bottom-0 right-0 w-96 flex justify-between items-center">
            <button type="button" class="leading-none transition duration-500 inline-flex items-center  focus:outline-none text-white bg-indigo-600 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-sm text-sm px-3 py-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-900">
                <BiorevIcon icon="plus" className="w-5 h-5 mx-1" />
                <span>Add New Client</span>
            </button>
            <button type="button" class="transition duration-500 inline-flex items-center  focus:outline-none text-red-500 border border-red-500 hover:bg-red-500 hover:text-white focus:ring-4 focus:ring-red-300 font-medium rounded-sm text-sm px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" @click="$emit('changeSidebarStatus')">
                <BiorevIcon icon="x" className="w-4 h-4 mx-1" />
                <span>Cancel</span>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    props: {
        hideSidebar:Boolean
    },
    
    computed: {
        sidebarStatus() {
            return this.hideSidebar
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