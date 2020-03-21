import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
    routes: [
        {
            name: "dashboard",
            path: "/",
            component: () => import("@/views/Dashboard")
        },
        {
            name: "activation",
            path: "/activation",
            component: () => import("@/views/Activation")
        },
        {
            name: "activities",
            path: "/activities",
            component: () => import("@/views/Activities")
        },
        {
            name: "login",
            path: "/login",
            component: () => import("@/views/Login")
        },
        {
            name: "settings",
            path: "/settings",
            component: () => import("@/views/Settings")
        },
        {
            name: "report-student",
            path: "/report/student",
            component: () => import("@/views/Report/Student")
        }
    ]
});