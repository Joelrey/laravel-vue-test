import { createWebHistory, createRouter } from "vue-router";
import axios from 'axios';
import store from '../store/index.js'
import Home from "../views/home";
import Login from "../views/login.vue";
import Register from "../views/register.vue";
import Welcome from "../views/welcome.vue";
import Records from "../views/records.vue";

axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.getters.isAuthenticated

const routes = [{
        path: "/",
        name: "home",
        components: {
            default: Home,
        },
    },
    {
        path: "/welcome",
        name: "welcome",
        components: {
            default: Welcome,
        },
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/login",
        name: "login",
        components: {
            default: Login,
        }
    },
    {
        path: "/register",
        name: "register",
        components: {
            default: Register,
        }
    },
    {
        path: "/records",
        name: "records",
        components: {
            default: Records,
        },
        meta: {
            forAdmin: true,
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth) && !store.getters.isAuthenticated) {
        return next({
            name: 'login',
        })
    }

    if (to.matched.some(record => record.meta.forAdmin) && !store.getters.getAuthUser.is_admin) {
        return next({
            name: 'home',
        })
    }

    next()
})

export default router;