import { createWebHistory, createRouter } from "vue-router";
import axios from 'axios';
import store from '../store/index.js'
import Home from "../components/Home.vue";
import Login from "../components/Login.vue";
import Register from "../components/Register.vue";
import Welcome from "../components/Welcome.vue";
import Records from "../components/Records.vue";

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

    next()
})

export default router;