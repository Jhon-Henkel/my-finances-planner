import {createRouter, createWebHistory} from '@ionic/vue-router'
import {RouteRecordRaw} from 'vue-router'
import TabsPage from '../views/TabsPage.vue'
import RouterAuthMiddleware from "@/router/RouterAuthMiddleware"

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
        component: TabsPage,
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
    },
    {
        path: '/v2/tabs/',
        component: TabsPage,
        children: [
            {
                path: '',
                redirect: '/v2/tabs/tab1'
            },
            {
                path: 'tab1',
                component: () => import('@/views/Tab1Page.vue')
            },
            {
                path: 'tab2',
                component: () => import('@/views/Tab2Page.vue')
            },
            {
                path: 'tab3',
                component: () => import('@/views/Tab3Page.vue')
            }
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach(RouterAuthMiddleware)

export default router
