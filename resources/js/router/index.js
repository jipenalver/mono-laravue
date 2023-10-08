import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("../components/Auth/Home.vue"),
        beforeEnter: (to, from) => {
            // When accessing guest pages, I want to be redirected to the default home page.
            if (sessionStorage.getItem("token") != null) {
                return "/dashboard";
            }
        },
    },
    {
        path: "/login",
        component: () => import("../components/Auth/Login.vue"),
        beforeEnter: (to, from) => {
            // When accessing guest pages, I want to be redirected to the default home page.
            if (sessionStorage.getItem("token") != null) {
                return "/dashboard";
            }
        },
    },
    {
        path: "/register",
        component: () => import("../components/Auth/Register.vue"),
        beforeEnter: (to, from) => {
            // When accessing guest pages, I want to be redirected to the default home page.
            if (sessionStorage.getItem("token") != null) {
                return "/dashboard";
            }
        },
    },
    {
        path: "/dashboard",
        component: () => import("../components/Dashboard/Dashboard.vue"),
        beforeEnter: (to, from) => {
            // When accessing protected pages, I want to be redirected to the login page.
            if (sessionStorage.getItem("token") == null) {
                return "/login";
            }
        },
    },
    {
        path: "/tasks",
        component: () => import("../components/Dashboard/Tasks.vue"),
        beforeEnter: (to, from) => {
            // When accessing protected pages, I want to be redirected to the login page.
            if (sessionStorage.getItem("token") == null) {
                return "/login";
            }
        },
    },
    {
        path: "/completed",
        component: () => import("../components/Dashboard/TaskCompleted.vue"),
        beforeEnter: (to, from) => {
            // When accessing protected pages, I want to be redirected to the login page.
            if (sessionStorage.getItem("token") == null) {
                return "/login";
            }
        },
    },
    {
        path: "/archives",
        component: () => import("../components/Dashboard/TaskArchives.vue"),
        beforeEnter: (to, from) => {
            // When accessing protected pages, I want to be redirected to the login page.
            if (sessionStorage.getItem("token") == null) {
                return "/login";
            }
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
