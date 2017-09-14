require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueMaterial from 'vue-material';

Vue.use(VueRouter);
Vue.use(VueMaterial);

Vue.material.registerTheme({
    default: {
        primary: {
            color: 'teal',
            hue: '700'
        },
        accent: 'red',
    },
    edit: {
        primary: {
            color: 'grey',
            hue: '700'
        },
        accent: {
            color: 'grey',
            hue: '700'
        }
    }
});

import Navbar from './components/header/Navbar.vue';
import Sidebar from './views/university/Sidebar.vue';

import router from './routes';

const app = new Vue({
    el: '#app',
    router: router,
    components: {
        Navbar,
        Sidebar
    }
});