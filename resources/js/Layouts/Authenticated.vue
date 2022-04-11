<script>
    import BiorevMenu from "@/Layouts/elements/Menu.vue";
    import BiorevHeader from "@/Layouts/elements/Header.vue";
   
    export default {
        components: {
            BiorevHeader,
            BiorevMenu,
        },
        data() {
            return {
                showNavigation:false,
                activeCondesnedMenu: false
            }
        },
        methods: {
            changeNavStatus() {
                if(this.showNavigation == true) {
                    this.showNavigation = false
                } else {
                    this.showNavigation = true
                }
            },
            changeSidemenu() {
                if(this.activeCondesnedMenu == true) {
                    this.activeCondesnedMenu = false
                } else {
                    this.activeCondesnedMenu = true
                }
            }
        }
    };
</script>
<style scoped>
aside {
    position: absolute;
    height: calc(100vh - 3.5rem);
    top: 3.5rem;
}
main{
    position: relative;
}
section.main-content{
    height: calc(100vh - 120px);
    overflow-y: auto;
}
</style>
<template>
    <div>
        <div class="min-h-screen bg-gray-100">
           <BiorevHeader @setMenu="changeNavStatus" :showingNavigationDropdown="showNavigation" @condensedMenu="changeSidemenu" :condensedSideMenu="activeCondesnedMenu" />

            <!-- Page Heading -->
            <BiorevMenu :showNavigation="showNavigation" :onCondesnedmenu="activeCondesnedMenu" />
            
            <!-- Page Content -->
            <main class="p-3 overflow-hidden transition-all duration-500" :class="[(activeCondesnedMenu)?'ml-16':'ml-64']">
                <header v-if="$slots.header">
                    <div class="pb-3">
                        <h2 class="font-normal text-xl text-gray-800 leading-tight">
                             <slot name="header" />
                        </h2>
                    </div>
                </header>
                <section class="main-content">
                    <slot />
                </section>
            </main>
        </div>
    </div>
</template>
