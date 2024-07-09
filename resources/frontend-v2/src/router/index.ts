import {createRouter, createWebHistory} from '@ionic/vue-router'
import {RouteRecordRaw} from 'vue-router'
import RouterAuthMiddleware from "@/router/RouterAuthMiddleware"
import MfpMenu from "@/views/menu/MfpMenu.vue"

const routes: Array<RouteRecordRaw> = [
    {
        path: '/v2',
        redirect: '/v2/login'
    },
    {
        path: '/v2/login',
        name: 'login',
        component: () => import('@/views/login/LoginPage.vue')
    },
    {
        path: '/v2/em-breve',
        name: 'in-development',
        component: () => import('@/views/in-development/InDevelopmentPage.vue')
    },
    {
        path: '/v2/',
        component: MfpMenu,
        children: [
            {
                path: 'carteiras',
                name: 'wallets',
                component: () => import('@/views/wallets/WalletsPage.vue')
            },
        ],
        meta: {
            auth: true
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach(RouterAuthMiddleware)

export default router
