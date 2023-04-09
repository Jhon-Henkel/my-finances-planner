import {createRouter, createWebHistory} from "vue-router";
import Home from "../../vue/Home.vue";
import Page2 from "../../vue/Page2.vue";

const routes = [
    {
        path: '/home',
        name: 'home',
        component: Home
    },
    {
        path: '/page2',
        name: 'page2',
        component: Page2
    }
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router