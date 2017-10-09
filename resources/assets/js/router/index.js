// Vue libs
import Vue from 'vue';
import VueRouter from 'vue-router';

// Other libs
import axios from 'axios';

// Store
import AuthStore from '../store/auth';

// Views, components
import Home from '../views/Home.vue'
import NotFound from '../views/NotFound.vue';

// Vue use
Vue.use(VueRouter);

// Vue router
const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/home', name: 'home', component: Home },
        { path: '*', component: NotFound },
    ]
});

// Axios global interceptors
axios.interceptors.response.use(null, err => {
    if (err.response.status === 401) {
        AuthStore.remove();
        router.push('login');
    }

    return Promise.reject(err);
});

router.beforeEach((to, from, next) => {
    if (to.path === '/') {
        next({ name: 'home' });
    } else {
        next();
    }
});

export default router;
