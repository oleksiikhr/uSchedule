
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var Vue = require('vue');
var VueMaterial = require('vue-material');

Vue.use(VueMaterial);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('navbar', require('./components/header/Navbar.vue'));
import Dashboard from './views/Dashboard.vue';
import Navbar from './components/header/Navbar.vue';

const app = new Vue({
    el: '#app',
    components: {
        Dashboard,
        Navbar
    }
});
