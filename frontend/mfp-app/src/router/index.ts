import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';
import HomePage from '../views/HomePage.vue'
import Login from '../views/Login.vue';
import Wallet from '../views/Wallet.vue';
import CreditCard from '../views/CreditCard.vue';
import Movement from '../views/Movement.vue';
import SpendingPlan from '../views/SpendingPlan.vue';
import EarningPlan from '../views/EarningPlan.vue';
import FinancialHealth from '../views/FinancialHealth.vue';
import User from '../views/User.vue';
import Configuration from '../views/Configuration.vue';
import MarketPlanner from '../views/MarketPlanner.vue';
import CreditCardInvoice from '../views/CreditCardInvoice.vue';

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        redirect: '/home'
    },
    {
        path: '/home',
        name: 'Home',
        component: HomePage
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/wallets',
        name: 'Wallets',
        component: Wallet,
    },
    {
        path: '/credit-cards',
        name: 'CreditCards',
        component: CreditCard,
    },
    {
        path: '/movements',
        name: 'Movements',
        component: Movement,
    },
    {
        path: '/spending-plans',
        name: 'SpendingPlans',
        component: SpendingPlan,
    },
    {
        path: '/earning-plans',
        name: 'EarningPlans',
        component: EarningPlan,
    },
    {
        path: '/financial-health',
        name: 'FinancialHealth',
        component: FinancialHealth,
    },
    {
        path: '/profile',
        name: 'Profile',
        component: User,
    },
    {
        path: '/configurations',
        name: 'Configurations',
        component: Configuration,
    },
    {
        path: '/market-planner',
        name: 'MarketPlanner',
        component: MarketPlanner,
    },
    {
        path: '/credit-card-invoices',
        name: 'CreditCardInvoices',
        component: CreditCardInvoice,
    },
]

import { useAuthStore } from '../stores/auth';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    const publicPages = ['/login'];
    const authRequired = !publicPages.includes(to.path);

    if (authRequired && !authStore.status.loggedIn) {
        return next('/login');
    }

    next();
});

export default router
