import {createRouter, createWebHistory} from '@ionic/vue-router'
import {RouteRecordRaw} from 'vue-router'
import RouterAuthMiddleware from "@/infra/router/RouterAuthMiddleware"
import MfpMenu from "@/modules/menu/MfpMenu.vue"
import {RouteName} from "@/infra/router/routeName"

const routes: Array<RouteRecordRaw> = [
    {
        path: '/v2',
        redirect: '/v2/login'
    },
    {
        path: '/v2/login',
        name: 'login',
        component: () => import('@/modules/login/page/LoginPage.vue')
    },
    {
        path: '/v2/registrar-se',
        name: 'register',
        component: () => import('@/modules/register/page/RegisterPage.vue')
    },
    {
        path: '/v2/registrado',
        name: 'register-done',
        component: () => import('@/modules/register/page/RegisterSuccessPage.vue')
    },
    {
        path: '/v2/ativar/:hash',
        name: 'activate-register',
        component: () => import('@/modules/register/component/RegisterActivateUser.vue')
    },
    {
        path: '/v2/assinatura-cancelada',
        name: 'subscribe-canceled',
        component: () => import('@/modules/subscription/page/SubscriptionCanceledPage.vue')
    },
    {
        path: '/v2/assinatura-sucesso',
        name: 'subscribe-success',
        component: () => import('@/modules/subscription/page/SubscriptionSuccessPage.vue')
    },
    {
        path: '/v2/bem-vindo',
        name: 'welcome',
        component: () => import('@/modules/welcome/WelcomePage.vue'),
        meta: {
            auth: true
        }
    },
    {
        path: '/v2/em-breve',
        name: 'in-development',
        component: () => import('@/modules/in-development/InDevelopmentPage.vue')
    },
    {
        path: '/v2/',
        component: MfpMenu,
        children: [
            {
                path: 'carteiras',
                name: 'wallets',
                component: () => import('@/modules/wallet/page/WalletsPage.vue')
            },
            {
                path: 'movimentacoes',
                name: 'movements',
                component: () => import('@/modules/movement/page/MovementsPage.vue')
            },
            {
                path: 'plano-de-gastos',
                name: RouteName.spending_plan,
                component: () => import('@/modules/spending-plan/page/SpendingPlanPage.vue')
            },
            {
                path: 'plano-de-ganhos',
                name: RouteName.earning_plan,
                component: () => import('@/modules/earning-plan/page/EarningPlanPage.vue')
            },
            {
                path: 'cartoes-de-credito',
                name: RouteName.credit_cards,
                component: () => import('@/modules/credit-card/page/CreditCardsPage.vue')
            },
            {
                path: 'cartoes-de-credito/:id/faturas',
                name: RouteName.credit_card_invoices,
                component: () => import('@/modules/credit-card/page/CreditCardInvoicePage.vue')
            },
            {
                path: 'dashboard',
                name: 'dashboard',
                component: () => import('@/modules/dashboard/page/DashboardPage.vue')
            },
            {
                path: 'saude-financeira',
                name: 'financial-health',
                component: () => import('@/modules/financial-health/page/FinancialHealthPage.vue')
            },
            {
                path: 'atualizando',
                name: 'updating',
                component: () => import('@/modules/updating/UpdatingPage.vue')
            },
        ],
        meta: {
            auth: true
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('@/modules/not-found/NotFoundPage.vue'),
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach(RouterAuthMiddleware)

export default router
