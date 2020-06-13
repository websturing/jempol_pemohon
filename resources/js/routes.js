import Vue from 'vue';
import VueRouter from 'vue-router';

import urlBase from '@/js/url';
import Dashboard from '@/js/components/Dashboard';
import profile from '@/js/components/Profile';
import login from '@/js/master/login';
import pendaftaran from '@/js/master/pendaftaran';
import pendaftaranSelesai from '@/js/master/pendaftaranSelesai';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    base: urlBase.urlBase,
    hash: false,
    routes: [
        {
            path: '/login',
            name: 'login',
            component: login
        },
        {
            path: '/pendaftaran',
            name: 'pendaftaran',
            component: pendaftaran
        },
        {
            path: '/pendaftaran/selesai',
            name: 'pendaftaran-selesai',
            component: pendaftaranSelesai
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: '/profile',
            name: 'profile',
            component: profile
        },
    ]
});

export default router;
