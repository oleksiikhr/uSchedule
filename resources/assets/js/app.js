
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var Vue = require('vue');
var VueMaterial = require('vue-material');

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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Auth
import LoginForm from './views/auth/Login.vue';
import RegisterForm from './views/auth/Register.vue';
import EmailForm from './views/auth/passwords/Email.vue';
import ResetForm from './views/auth/passwords/Reset.vue';

import Dashboard from './views/Dashboard.vue';
import Navbar from './components/header/Navbar.vue';
import Edit from './views/schedule/Edit.vue';

const app = new Vue({
    el: '#app',
    components: {
        Dashboard,
        Navbar,
        LoginForm,
        RegisterForm,
        Edit,
        EmailForm,
        ResetForm,
    }
});
