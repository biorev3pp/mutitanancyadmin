require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp, Link, Head} from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import BiorevIcon from "@/Components/BiorevIcon.vue";

import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const { $buttonClasses, $formClasses } = require('@/Helpers/BiorevCss.js');

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Biorev - Superadmin';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const myApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueToast, {position:'top-right'})
            .mixin({ methods: { route } })
            .component("Link", Link)
            .component("Head", Head)
            .component("BiorevIcon", BiorevIcon);

        myApp.config.globalProperties.$buttonClasses = $buttonClasses;
        myApp.config.globalProperties.$formClasses = $formClasses;
       // myApp.config.globalProperties.$toast = toast;
        myApp.mount(el);

        return myApp;
    },
});

InertiaProgress.init({ color: '#4B5563' , showSpinner : true, includeCSS: true,});
