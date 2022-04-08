<script>
    import { Link } from '@inertiajs/inertia-vue3';
    import { ref, computed  } from 'vue';
    import { usePage } from '@inertiajs/inertia-vue3'
    export default {
        components: {
            Link,
            ref
        },
        props: {
            showNavigation: [Boolean],
        },
        setup() {
            const activeMenu = computed(() => usePage().props.value.menu)
            return { activeMenu }
        }
    }
</script>
<template>
    
    <aside class="w-64 transition-all z-50 duration-500 bg-slate-700 md:block" aria-label="Sidebar" :class="{'block': showNavigation, 'hidden': ! showNavigation}">
        <div class="overflow-y-auto bg-slate-700">
            <ul class="">
                <li>
                    <Link :href="route('dashboard')" class="flex items-center px-2 py-3.5 text-sm font-normal   text-white hover:bg-slate-900  transition duration-500" :class="{'bg-slate-800 ': (activeMenu == 'dashboard')}">
                        <BiorevIcon icon="chart-pie" className="flex-shrink-0 w-5 h-5 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" />
                        <span class="ml-3">Dashboard</span>
                    </Link>
                </li>
            <li>
                <Link :href="route('setup-client')" class="flex items-center px-2 py-3.5 text-sm font-normal   text-white bg-indigo-500 transition duration-500">
                     <BiorevIcon icon="user-add" className="flex-shrink-0 w-5 h-5 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Setup Client</span>
                </Link>
            </li>
            <li>
                <Link :href="route('clients')" class="flex items-center px-2 py-3.5 text-sm font-normal   text-white hover:bg-slate-900 transition duration-500" :class="{'bg-slate-800 ': (activeMenu == 'clients')}">
                     <BiorevIcon icon="user-group" className="flex-shrink-0 w-5 h-5 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Clients</span>
                </Link>
            </li>
            <li>
                <Link :href="route('domains')" class="flex items-center px-2 py-3.5 text-sm font-normal   text-white hover:bg-slate-900 transition duration-500" :class="{'bg-slate-800 ': (activeMenu == 'domains')}">
                    <BiorevIcon icon="library" className="flex-shrink-0 w-5 h-5 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Domains</span>
                </Link>
            </li>
            <li>
                <Link :href="route('database')" class="flex items-center px-2 py-3.5 text-sm font-normal   text-white hover:bg-slate-900 transition duration-500" :class="{'bg-slate-800 ': (activeMenu == 'database')}">
                    <BiorevIcon icon="database" className="flex-shrink-0 w-5 h-5 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Database</span>
                </Link>
            </li>
            <li>
                <Link :href="route('server')" class="flex items-center px-2 py-3.5 text-sm font-normal   text-white hover:bg-slate-900  transition duration-500" :class="{'bg-slate-800 ': (activeMenu == 'server')}">
                    <BiorevIcon icon="shopping-bag" className="flex-shrink-0 w-5 h-5 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Server </span>
                </Link>
            </li>
            </ul>
        </div>
    </aside>

</template>