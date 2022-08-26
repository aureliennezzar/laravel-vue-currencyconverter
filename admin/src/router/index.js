import {createRouter, createWebHistory} from 'vue-router';

const routes = [
    {
        name: 'Home',
        path: '/',
        component: () => import('../views/Home/Home.vue'),
    },
    {
        name: 'Login',
        path: '/login',
        component: () => import('../views/Login/Login.vue'),
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router;
