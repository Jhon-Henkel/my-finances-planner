import {createRouter, createWebHistory} from "vue-router";
import PageNotFoundView from "../../vue/view/PageNotFoundView.vue";

const routes = [
    {
        path: "/:pathMatch(.*)*",
        name: 'not-found',
        component: PageNotFoundView
    }
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router