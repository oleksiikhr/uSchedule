// Other libs
window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
window.axios = require('axios');

// Other config
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Vue libs
import Vue from 'vue';
import Vuetify from 'vuetify';

// Vue files
import App from './App.vue';
import router from './router/index';

// Vue use
Vue.use(Vuetify);


const app = new Vue({
    el: '#app',
    template: '<app></app>',
    components: { App },
    router
});
