import {createRouter, createWebHistory} from 'vue-router';
import store from "../store";

const routes = [
    {
        name: 'Login',
        path: '/login',
        component: () => import('../views/Login/Login.vue'),
    },
    {
        name: 'Dashboard',
        path: '/',
        component: () => import('../views/Dashboard/Dashboard.vue'),
        meta: {requiresAuth: true}
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    const currentUser = store.state.user.token;
    console.log(currentUser);
    if ( to.meta.requiresAuth && !currentUser ) {
        next({name: 'Login'})
    } else if (to.path=== "/login" && currentUser) {
        next('/')
    } else {
        console.log("GOOD")
        next();
    }
})

export default router;
