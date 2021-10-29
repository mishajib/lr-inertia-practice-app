require('./bootstrap');

import Vue                from 'vue';
import {createInertiaApp} from '@inertiajs/inertia-vue';
import {InertiaProgress}  from '@inertiajs/progress';
import {Link}             from '@inertiajs/inertia-vue';
import {Head}             from '@inertiajs/inertia-vue';

Vue.component('inertia-link', Link);
Vue.component('head-component', Head);

InertiaProgress.init();

Vue.component('app-layout', require('./Layouts/AppComponent').default);

createInertiaApp({
    resolve : name => require(`./Pages/${name}`),
    setup({el, App, props}) {
        new Vue({
            render : h => h(App, props),
        }).$mount(el)
    },
});
