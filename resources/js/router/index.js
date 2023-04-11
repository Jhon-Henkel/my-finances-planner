import {createRouter, createWebHistory} from "vue-router";
import PageNotFoundView from "../../vue/view/PageNotFoundView.vue";
import WalletView from "../../vue/view/WalletView.vue";
import DashboardView from "../../vue/view/DashboardView.vue";
import MovementView from "../../vue/view/MovementView.vue";
import PanoramView from "../../vue/view/PanoramView.vue";
import FutureGainView from "../../vue/view/FutureGainView.vue";
import ConfigurationsView from "../../vue/view/ConfigurationsView.vue";
import ExpensesCardsView from "../../vue/view/ExpensesCardsView.vue";
import ManageCardsView from "../../vue/view/ManageCardsView.vue";

const routes = [
    {
        path: "/dashboard",
        name: "dashboard",
        component: DashboardView
    },
    {
        path: "/movimentacoes",
        name: "movement",
        component: MovementView
    },
    {
        path: "/panorama",
        name: "panoram",
        component: PanoramView
    },
    {
        path: "/ganhos-futuros",
        name: "futureGain",
        component: FutureGainView
    },
    {
        path: "/carteiras",
        name: "wallets",
        component: WalletView
    },
    {
        path: "/gerenciar-cartoes",
        name: "manageCards",
        component: ManageCardsView
    },
    {
        path: "/despesas-cartoes",
        name: "expensesCards",
        component: ExpensesCardsView
    },
    {
        path: "/configuracoes",
        name: "configurations",
        component: ConfigurationsView
    },
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