import Vue from 'vue';
import VueRouter from 'vue-router';

import urlBase from '@/js/url';
import Dashboard from '@/js/components/Dashboard';
import profile from '@/js/components/Profile';
import login from '@/js/master/login';
import pendaftaran from '@/js/master/pendaftaran';
import pendaftaranSelesai from '@/js/master/pendaftaranSelesai';
import permohonanpengajuan from '@/js/components/permohonan/pengajuan';
import permohonantertunda from '@/js/components/permohonan/tertunda';
import permohonanprosesData from '@/js/components/permohonan/proses';
import permohonantrack from '@/js/components/permohonan/track';
import permohonanproses from '@/js/components/permohonan/detail';

import trackByid from '@/js/components/track/Byid';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    base: urlBase.urlBase,
    hash: false,
    routes: [{
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
        {
            path: '/permohonan/pengajuan/:id',
            name: 'permohonan-pengajuan',
            component: permohonanpengajuan
        },
        {
            path: '/permohonan/tertunda',
            name: 'permohonan-tertunda',
            component: permohonantertunda
        },
        {
            path: '/permohonan/track',
            name: 'permohonan-track',
            component: permohonantrack
        },
        {
            path: '/permohonan/detail/:id',
            name: 'permohonan-detail',
            component: permohonanproses
        },
        {
            path: '/permohonan/proses',
            name: 'permohonan-proses',
            component: permohonanprosesData
        },
        {
            path: '/track/:id',
            name: 'track-Byid',
            component: trackByid
        },



    ]
});

export default router;
