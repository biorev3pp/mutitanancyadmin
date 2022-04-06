<script setup>

import BiorevMenu from "@/Layouts/elements/Menu.vue";
import BiorevHeader from "@/Layouts/elements/Header.vue";

</script>
<style scoped>
aside {
    position: absolute;
    height: calc(100vh - 3.5rem);
    background: #323232;
    top: 3.5rem;
}
main{
    position: relative;
    width: calc();
    margin-left: 16em;
    padding: 12px;
}
section.main-content{
    height: calc(100vh - 120px);
    background: #fff;
    overflow-y: auto;
}
</style>
<template>
    <div>
        <div class="min-h-screen bg-gray-100">
           <BiorevHeader />

            <!-- Page Heading -->
            <BiorevMenu />
            
            <!-- Page Content -->
            <main>
                <header v-if="$slots.header">
                    <div class="pb-3">
                        <slot name="header" />
                    </div>
                </header>
                <section class="main-content">
                    <slot />
                </section>
            </main>
        </div>
    </div>
</template>
