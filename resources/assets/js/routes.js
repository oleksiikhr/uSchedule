import VueRouter from 'vue-router';

let routes = [
    {
        path: '/subjects',
        component: require('./views/university/subject/Subjects'),
    },
    {
        path: '/teachers',
        component: require('./views/university/teacher/Teachers')
    },
    {
        path: '/schedules',
        component: require('./views/university/schedule/Schedules')
    },

];

export default new VueRouter({
    routes,
    linkActiveClass: 'menu-active'
})