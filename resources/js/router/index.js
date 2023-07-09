import {createRouter, createWebHistory} from "vue-router";
import PageNotFoundView from "../../vue/view/PageNotFoundView.vue";
import WalletView from "../../vue/view/wallet/WalletView.vue";
import DashboardView from "../../vue/view/dashboard/DashboardView.vue";
import WalletFormView from "../../vue/view/wallet/WalletFormView.vue";
import ManageCardsView from "../../vue/view/creditCard/ManageCardsView.vue";
import ManageCardsFormView from "../../vue/view/creditCard/ManageCardsFormView.vue";
import LoginView from "../../vue/view/login/LoginView.vue";
import CreditCardInvoiceView from "../../vue/view/creditCard/invoice/CreditCardInvoiceView.vue";
import CreditCardExpenseForm from "../../vue/view/creditCard/expense/CreditCardExpenseForm.vue";
import MovementView from "../../vue/view/movement/MovementView.vue";
import MovementForm from "../../vue/view/movement/MovementForm.vue";
import FutureGainView from "../../vue/view/futureGain/FutureGainView.vue";
import FutureGainForm from "../../vue/view/futureGain/FutureGainForm.vue";
import ToolsView from "../../vue/view/tools/ToolsView.vue";
import SalaryCalculator from "../../vue/view/tools/salaryCalculator/SalaryCalculator.vue";
import ExtraHoursCalculator from "../../vue/view/tools/extraHoursCalculator/ExtraHoursCalculator.vue";
import ConfigurationsView from "../../vue/view/configurations/ConfigurationsView.vue";
import PanoramaView from "../../vue/view/panorama/PanoramaView.vue";
import PanoramaForm from "../../vue/view/panorama/PanoramaForm.vue";
import AboutView from "../../vue/view/about/AboutView.vue";
import PanoramaAllSpentAndGain from "../../vue/view/panorama/PanoramaAllSpentAndGain.vue";
import FinancialHealthView from "../../vue/view/tools/financialHealth/FinancialHealthView.vue";
import MonthlyClosingView from "../../vue/view/tools/monthlyClosing/MonthlyClosingView.vue";
import MovementTransferForm from "../../vue/view/movement/MovementTransferForm.vue";

const routes = [
    {
        path: "/sobre",
        name: "about",
        component: AboutView
    },
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
        children: [
            {
                path: "",
                name: "movementList",
                component: MovementView
            },
            {
                path: "cadastrar",
                name: "movementRegister",
                component: MovementForm
            },
            {
                path: ":id/atualizar",
                name: "movementUpdate",
                component: MovementForm
            },
            {
                path: "transferir",
                name: "newTransfer",
                component: MovementTransferForm
            }
        ]
    },
    {
        path: "/panorama",
        children: [
            {
                path: "",
                name: "panorama",
                component: PanoramaView
            },
            {
                path: "cadastrar-despesa",
                name: "panoramaRegister",
                component: PanoramaForm
            },
            {
                path: ":id/atualizar-despesa",
                name: "panoramaUpdate",
                component: PanoramaForm
            },
            {
                path: "todas-despesas-e-ganhos",
                name: "manageAllSpentAndGain",
                component: PanoramaAllSpentAndGain
            }
        ]
    },
    {
        path: "/ganhos-futuros",
        children: [
            {
                path: "",
                name: "futureGainList",
                component: FutureGainView
            },
            {
                path: "cadastrar",
                name: "futureGainRegister",
                component: FutureGainForm
            },
            {
                path: ":id/atualizar",
                name: "futureGainUpdate",
                component: FutureGainForm
            }
        ]
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
                component: ManageCardsView
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
            },
        ]
    },
    {
        path: "/gerenciar-cartoes/despesa",
        children: [
            {
                path: "cadastrar",
                name: "manageCardsExpenseRegister",
                component: CreditCardExpenseForm
            },
            {
                path: ":cardId/cadastrar",
                name: "manageCardsExpenseRegisterWithCard",
                component: CreditCardExpenseForm
            },
            {
                path: ":id/atualizar",
                name: "manageCardsExpenseUpdate",
                component: CreditCardExpenseForm
            },
        ]
    },
    {
        path: "/gerenciar-cartoes/fatura-cartao",
        children: [
            {
                path: ":id",
                name: "creditCardsInvoices",
                component: CreditCardInvoiceView
            },
        ]
    },
    {
        path: "/ferramentas",
        children: [
            {
                path: "",
                name: "tools",
                component: ToolsView
            },
            {
                path: "calculadora-salario",
                name: "salaryCalculator",
                component: SalaryCalculator
            },
            {
                path: "calculadora-horas-extras",
                name: "extraHoursCalculator",
                component: ExtraHoursCalculator
            },
            {
                path: "saude-financeira",
                name: "financialHealth",
                component: FinancialHealthView
            },
            {
                path: "fechamento-mensal",
                name: "monthlyClosing",
                component: MonthlyClosingView
            }
        ]
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
    history: createWebHistory(),
    routes
})

export default router