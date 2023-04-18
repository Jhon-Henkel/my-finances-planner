import {createRouter, createWebHistory} from "vue-router";
import PageNotFoundView from "../../vue/view/PageNotFoundView.vue";
import WalletView from "../../vue/view/wallet/WalletView.vue";
import DashboardView from "../../vue/view/DashboardView.vue";
import MovementView from "../../vue/view/MovementView.vue";
import PanoramView from "../../vue/view/PanoramView.vue";
import FutureGainView from "../../vue/view/FutureGainView.vue";
import ConfigurationsView from "../../vue/view/ConfigurationsView.vue";
import ExpensesCardsView from "../../vue/view/ExpensesCardsView.vue";
import WalletFormView from "../../vue/view/wallet/WalletFormView.vue";
import manageCardsView from "../../vue/view/creditCard/ManageCardsView.vue";
import ManageCardsFormView from "../../vue/view/creditCard/ManageCardsFormView.vue";
import LoginView from "../../vue/view/login/LoginView.vue";

const routes = [
    {
        path: "/login",
        name: "login",
        component: LoginView
    },
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
        children: [
            {
                path: "",
                name: "walletList",
                component: WalletView
            },
            {
                path: "cadastrar",
                name: "walletRegister",
                component: WalletFormView
            },
            {
                path: ":id/atualizar",
                name: "walletUpdate",
                component: WalletFormView
            }
        ]
    },
    {
        path: "/gerenciar-cartoes",
        children: [
            {
                path: "",
                name: "manageCards",
                component: manageCardsView
            },
            {
                path: "cadastrar",
                name: "manageCardsRegister",
                component: ManageCardsFormView
            },
            {
                path: ":id/atualizar",
                name: "manageCardsUpdate",
                component: ManageCardsFormView
            }
        ]
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