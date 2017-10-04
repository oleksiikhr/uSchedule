// Vue libs
import Vue from 'vue';
import VueRouter from 'vue-router';

// Vue use
Vue.use(VueRouter);

// Views, components
import Home from '../views/Home.vue'
import NotFound from '../views/NotFound.vue';


export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: Home },
        { path: '*', component: NotFound },
    ]
});
