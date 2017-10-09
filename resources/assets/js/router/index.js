// Vue libs
import Vue from 'vue';
import VueRouter from 'vue-router';

// Other libs
import axios from 'axios';

// Store
import AuthStore from '../store/auth';

// Views, components
import Home from '../views/Home.vue';
import Profile from '../views/users/Profile.vue';
import Login from '../views/auth/Login.vue';
import NotFound from '../views/NotFound.vue';

// Vue use
Vue.use(VueRouter);

// Vue router
const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/home', name: 'home', component: Home },
        { path: '/profile', name: 'profile', component: Profile, meta: { isLogin: true } },
        { path: '/login', name: 'login', component: Login, meta: { isLogin: false } },
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
    } else if (to.meta.isLogin && !AuthStore.state.token) {
        next({ name: 'login' });
    } else if (!to.meta.isLogin && AuthStore.state.token) {
        next({ name: 'home' });
    } else {
        next();
    }
});

export default router;
