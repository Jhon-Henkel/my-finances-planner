import {createRouter, createWebHistory} from "vue-router";

const routes = [
    {
        path: "/sobre",
        name: "about",
        component: () => import("../../vue/view/about/AboutView.vue")
    },
    {
        path: "/login",
        name: "login",
        component: () => import("../../vue/view/login/LoginView.vue")
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: () => import("../../vue/view/dashboard/DashboardView.vue")
    },
    {
        path: "",
        name: "dashboardRoot",
        component: () => import("../../vue/view/dashboard/DashboardView.vue")
    },
    {
        path: "/movimentacoes",
        children: [
            {
                path: "",
                name: "movementList",
                component: () => import("../../vue/view/movement/MovementView.vue")
            },
            {
                path: "cadastrar",
                name: "movementRegister",
                component: () => import("../../vue/view/movement/MovementForm.vue")
            },
            {
                path: ":id/atualizar",
                name: "movementUpdate",
                component: () => import("../../vue/view/movement/MovementForm.vue")
            },
            {
                path: "transferir",
                name: "newTransfer",
                component: () => import("../../vue/view/movement/MovementTransferForm.vue")
            }
        ]
    },
    {
        path: "/panorama",
        children: [
            {
                path: "",
                name: "panorama",
                component: () => import("../../vue/view/panorama/PanoramaView.vue")
            },
            {
                path: "cadastrar-despesa",
                name: "panoramaRegister",
                component: () => import("../../vue/view/panorama/PanoramaForm.vue")
            },
            {
                path: ":id/atualizar-despesa",
                name: "panoramaUpdate",
                component: () => import("../../vue/view/panorama/PanoramaForm.vue")
            },
            {
                path: "todas-despesas-e-ganhos",
                name: "manageAllSpentAndGain",
                component: () => import("../../vue/view/panorama/PanoramaAllSpentAndGain.vue")
            }
        ]
    },
    {
        path: "/ganhos-futuros",
        children: [
            {
                path: "",
                name: "futureGainList",
                component: () => import("../../vue/view/futureGain/FutureGainView.vue")
            },
            {
                path: "cadastrar",
                name: "futureGainRegister",
                component: () => import("../../vue/view/futureGain/FutureGainForm.vue")
            },
            {
                path: ":id/atualizar",
                name: "futureGainUpdate",
                component: () => import("../../vue/view/futureGain/FutureGainForm.vue")
            }
        ]
    },
    {
        path: "/carteiras",
        children: [
            {
                path: "",
                name: "walletList",
                component: () => import("../../vue/view/wallet/WalletView.vue")
            },
            {
                path: "cadastrar",
                name: "walletRegister",
                component: () => import("../../vue/view/wallet/WalletFormView.vue")
            },
            {
                path: ":id/atualizar",
                name: "walletUpdate",
                component: () => import("../../vue/view/wallet/WalletFormView.vue")
            }
        ]
    },
    {
        path: "/gerenciar-cartoes",
        children: [
            {
                path: "",
                name: "manageCards",
                component: () => import("../../vue/view/creditCard/ManageCardsView.vue")
            },
            {
                path: "cadastrar",
                name: "manageCardsRegister",
                component: () => import("../../vue/view/creditCard/ManageCardsFormView.vue")
            },
            {
                path: ":id/atualizar",
                name: "manageCardsUpdate",
                component: () => import("../../vue/view/creditCard/ManageCardsFormView.vue")
            },
        ]
    },
    {
        path: "/gerenciar-cartoes/despesa",
        children: [
            {
                path: "cadastrar",
                name: "manageCardsExpenseRegister",
                component: () => import("../../vue/view/creditCard/expense/CreditCardExpenseForm.vue")
            },
            {
                path: ":cardId/cadastrar",
                name: "manageCardsExpenseRegisterWithCard",
                component: () => import("../../vue/view/creditCard/expense/CreditCardExpenseForm.vue")
            },
            {
                path: ":id/atualizar",
                name: "manageCardsExpenseUpdate",
                component: () => import("../../vue/view/creditCard/expense/CreditCardExpenseForm.vue")
            },
        ]
    },
    {
        path: "/gerenciar-cartoes/fatura-cartao",
        children: [
            {
                path: ":id",
                name: "creditCardsInvoices",
                component: () => import("../../vue/view/creditCard/invoice/CreditCardInvoiceView.vue")
            },
        ]
    },
    {
        path: "/ferramentas",
        children: [
            {
                path: "",
                name: "tools",
                component: () => import("../../vue/view/tools/ToolsView.vue")
            },
            {
                path: "calculadora-salario",
                name: "salaryCalculator",
                component: () => import("../../vue/view/tools/salaryCalculator/SalaryCalculator.vue")
            },
            {
                path: "calculadora-horas-extras",
                name: "extraHoursCalculator",
                component: () => import("../../vue/view/tools/extraHoursCalculator/ExtraHoursCalculator.vue")
            },
            {
                path: "saude-financeira",
                name: "financialHealth",
                component: () => import("../../vue/view/tools/financialHealth/FinancialHealthView.vue")
            },
            {
                path: "fechamento-mensal",
                name: "monthlyClosing",
                component: () => import("../../vue/view/tools/monthlyClosing/MonthlyClosingView.vue")
            }
        ]
    },
    {
        path: "/configuracoes",
        name: "configurations",
        component: () => import("../../vue/view/configurations/ConfigurationsView.vue")
    },
    {
        path: "/:pathMatch(.*)*",
        name: 'not-found',
        component: () => import("../../vue/view/PageNotFoundView.vue")
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router