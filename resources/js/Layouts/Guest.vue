<script setup>
import DarkLogo from '@/Components/ApplicationDarkLogo';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-0 sm:pt-0 bg-gray-100 pb-64">
        <div>
            <Link href="/">
                <DarkLogo class="fill-current text-gray-500" />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
