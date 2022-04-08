<script setup>
const { computed }= require("@vue/runtime-core");

const props = defineProps({
                icon: {
                    type: String,
                    default: '',
                },
                strokeColor: {
                    type: String,
                    default: 'currentColor',
                },
                fillColor: {
                    type: String,
                    default: 'none',
                },
                strokeWidth: {
                    type: Number,
                    default: 2,
                },
                className: {
                    type: String,
                    default: 'w-6 h-6',
                }
            });

const icontext = computed(() => {
        switch (props.icon) {
            case 'ArrowNarrowLeft':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
            case 'plus':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
            case 'search':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>';
            case 'x-circle':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
            case 'x':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M6 18L18 6M6 6l12 12"></path>';
            case 'shopping-bag':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>';
            case 'database':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>';
            case 'library':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>';
            case 'user':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>';
            case 'user-add':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>';
            case 'user-group':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>';
            case 'chart-pie':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>';
            case 'menu-alt2':
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M4 6h16M4 12h16M4 18h7"></path>';
            default:
                return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="'+props.strokeWidth+'" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
        }
    })
</script>

<template>
    <svg :class="className" :fill="fillColor" :stroke="strokeColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" v-html="icontext">
    </svg>
</template>
