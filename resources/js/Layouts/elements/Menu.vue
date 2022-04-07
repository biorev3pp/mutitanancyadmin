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
            <ul class="divide-y divide-slate-600">
                <li>
                    <Link :href="route('dashboard')" class="flex items-center px-2 py-3 text-sm font-normal   text-white hover:bg-slate-900  transition duration-500" :class="{'bg-slate-800 ': (activeMenu == 'dashboard')}">
                        <svg class="w-6 h-6 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                        <span class="ml-3">Dashboard</span>
                    </Link>
                </li>
            <li>
                <Link :href="route('setup-client')" class="flex items-center px-2 py-3 text-sm font-normal   text-white bg-indigo-500 transition duration-500">
                    <svg class="flex-shrink-0 w-6 h-6 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Setup Client</span>
                </Link>
            </li>
            <li>
                <Link :href="route('clients')" class="flex items-center px-2 py-3 text-sm font-normal   text-white hover:bg-slate-900 transition duration-500" :class="{'bg-slate-800 ': (activeMenu == 'clients')}">
                    <svg class="flex-shrink-0 w-6 h-6 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Clients</span>
                </Link>
            </li>
            <li>
                <Link :href="route('domains')" class="flex items-center px-2 py-3 text-sm font-normal   text-white hover:bg-slate-900 transition duration-500" :class="{'bg-slate-800 ': (activeMenu == 'domains')}">
                    <svg class="flex-shrink-0 w-6 h-6 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path><path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Domains</span>
                </Link>
            </li>
            <li>
                <Link :href="route('database')" class="flex items-center px-2 py-3 text-sm font-normal   text-white hover:bg-slate-900 transition duration-500" :class="{'bg-slate-800 ': (activeMenu == 'database')}">
                    <svg class="flex-shrink-0 w-6 h-6 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Database</span>
                </Link>
            </li>
            <li>
                <a href="#" class="flex items-center px-2 py-3 text-sm font-normal   text-white hover:bg-slate-900  transition duration-500" :class="{'bg-slate-800 ': (activeMenu == 'server')}">
                    <svg class="flex-shrink-0 w-6 h-6 text-white-500 transition duration-75 dark:text-white-400 group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Server </span>
                </a>
            </li>

            </ul>
        </div>
    </aside>

</template>