<script>
    import { ref } from 'vue';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import BreezeDropdown from '@/Components/Dropdown.vue';
    import BreezeDropdownLink from '@/Components/DropdownLink.vue';
    import BreezeNavLink from '@/Components/NavLink.vue';
    import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import { Link } from '@inertiajs/inertia-vue3';
    
    export default {
        components: {
            ApplicationLogo,
            Link,
            BreezeDropdown,
            BreezeDropdownLink,
            BreezeNavLink,
            BreezeResponsiveNavLink,
            ref
        },
        props: {
            showingNavigationDropdown:[Boolean]
        },
        setup () {
            
        }
    };
    
</script>
<template>
     <nav class="bg-white border-b border-gray-100">
        <div class="mx-auto pr-2">
            <div class="flex justify-between h-14">
                <div class="flex md:bg-slate-700 md:w-64">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center p-0">
                        <Link :href="route('dashboard')" class="px-2 py-2.5 md:border-b border-slate-600 w-64">
                            <ApplicationLogo class="block" />
                        </Link>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <BreezeDropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ $page.props.auth.user.name }}
                                        <BiorevIcon icon="menu-alt2" className="ml-2 -mr-0.5 h-4 w-4" />
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </BreezeDropdownLink>
                            </template>
                        </BreezeDropdown>
                    </div>
                </div>
                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="$emit('setMenu')" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

                <!-- Responsive Navigation Menu -->
                <div class="hidden sm:hidden">

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>
</template>