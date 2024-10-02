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
        path: '/v2/registrar-se',
        name: 'register',
        component: () => import('@/views/register/RegisterPage.vue')
    },
    {
        path: '/v2/registrado',
        name: 'register-done',
        component: () => import('@/views/register/RegisterSuccessPage.vue')
    },
    {
        path: '/v2/ativar/:hash',
        name: 'activate-register',
        component: () => import('@/views/register/RegisterActivateUser.vue')
    },
    {
        path: '/v2/assinatura-cancelada',
        name: 'subscribe-canceled',
        component: () => import('@/views/subscription/SubscriptionCanceledPage.vue')
    },
    {
        path: '/v2/assinatura-sucesso',
        name: 'subscribe-success',
        component: () => import('@/views/subscription/SubscriptionSuccessPage.vue')
    },
    {
        path: '/v2/bem-vindo',
        name: 'welcome',
        component: () => import('@/views/welcome/WelcomePage.vue'),
        meta: {
            auth: true
        }
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
            {
                path: 'movimentacoes',
                name: 'movements',
                component: () => import('@/views/movement/MovementsPage.vue')
            },
            {
                path: 'panorama',
                name: 'panorama',
                component: () => import('@/views/panorama/PanoramaPage.vue')
            },
            {
                path: 'ganhos-futuros',
                name: 'future-profits',
                component: () => import('@/views/future-profits/FutureProfitsPage.vue')
            },
            {
                path: 'gerenciar-cartoes',
                name: 'manage-cards',
                component: () => import('@/views/cards/CardsPage.vue')
            },
            {
                path: 'gerenciar-cartoes/fatura-cartao/:id',
                name: 'card-invoices',
                component: () => import('@/views/cards/invoice/CardInvoicesPage.vue')
            },
            {
                path: 'dashboard',
                name: 'dashboard',
                component: () => import('@/views/dashboard/DashboardPage.vue')
            },
            {
                path: 'saude-financeira',
                name: 'financial-health',
                component: () => import('@/views/financial-health/FinancialHealthPage.vue')
            },
            {
                path: 'atualizando',
                name: 'updating',
                component: () => import('@/views/updating/UpdatingPage.vue')
            },
        ],
        meta: {
            auth: true
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('@/views/not-found/NotFoundPage.vue'),
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach(RouterAuthMiddleware)

export default router
