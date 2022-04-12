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
                activeCondesnedMenu: false,
                darkModeStatus: false
            }
        },
        methods: {
            changeNavStatus() {
                this.showNavigation = !this.showNavigation
            },
            changeSidemenu() {
                this.activeCondesnedMenu = !this.activeCondesnedMenu
            },
            changeThemeMode() {
                this.darkModeStatus =  !this.darkModeStatus
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark')
                } else {
                    document.documentElement.classList.remove('dark')
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
           <BiorevHeader @setMenu="changeNavStatus" :showingNavigationDropdown="showNavigation" @condensedMenu="changeSidemenu" :condensedSideMenu="activeCondesnedMenu" :dark-mode-status="darkModeStatus" @changeThemeMode="changeThemeMode" />

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
