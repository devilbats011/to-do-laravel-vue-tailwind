require("./bootstrap");
import Vue from "vue";
import VueRouter from "vue-router";
import LoginTodo from "./views/page/LoginTodo.vue";
import DisplayTodo from "./views/page/DisplayTodo.vue";
import RegisterTodo from "./views/page/RegisterTodo.vue";
import PlanPackageTodo from "./views/page/PlanPackageTodo.vue";
import CreateTodo from "./views/page/CreateTodo.vue";
import EditTodo from "./views/page/EditTodo.vue";
import NotFound from "./views/page/NotFound.vue";



const routes = [
    { path: "*", name: "not-found", component: NotFound },
    {
        path: "/",
        name: "loginTodo",
        component: LoginTodo,
     
    },
    {
        path: "/display",
        name: "display",
        component: DisplayTodo,
     
    },
    {
        path: "/register",
        name: "register",
        component: RegisterTodo,
     
    },
    {
        path: "/create",
        name: "create",
        component: CreateTodo,
     
    },
    {
        path: "/edit",
        name: "edit",
        component: EditTodo,
     
    },
    {
        path: "/plan-package",
        name: "plan-package",
        component: PlanPackageTodo,
     
    },
];



Vue.use(VueRouter);
const router = new VueRouter({
    mode: "history", //removes # (hashtag) from url
    history: true,
    hashbang: false,
    linkActiveClass: "active",
    routes,
});

const helper = {
    install(Vue, options) {
        Vue.prototype.helperTo = (_name) => {
            router.push({ path: _name });
        };
    },
};
Vue.use(helper);

const app = new Vue({
    el: "#app",
    router,
});
//.$mount("#app");
