import './bootstrap';
import Vue from 'vue';
import Routes from '@/js/routes.js';

import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(ElementUI, {
    locale
});


const app = new Vue({
    el: '#app',
    router: Routes,
    data: {
        activeContent: true,
        activeLogin: false
    },
});
