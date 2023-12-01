import { createRouter, createWebHistory } from 'vue-router'
import routesControl from './routes.js'

const routes = [
    {
        path: '/sobre',
        name: 'about',
        component: () => import('../../vue/view/about/AboutView.vue'),
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../../vue/view/login/LoginView.vue'),
        meta: {
            auth: false
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import('../../vue/view/dashboard/DashboardView.vue'),
        meta: {
            auth: true
        }
    },
    {
        path: '',
        name: 'dashboardRoot',
        component: () => import('../../vue/view/dashboard/DashboardView.vue'),
        meta: {
            auth: true
        }
    },
    {
        path: '/movimentacoes',
        children: [
            {
                path: '',
                name: 'movementList',
                component: () => import('../../vue/view/movement/MovementView.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'cadastrar',
                name: 'movementRegister',
                component: () => import('../../vue/view/movement/MovementForm.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: ':id/atualizar',
                name: 'movementUpdate',
                component: () => import('../../vue/view/movement/MovementForm.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'transferir',
                name: 'newTransfer',
                component: () => import('../../vue/view/movement/MovementTransferForm.vue'),
                meta: {
                    auth: true
                }
            }
        ]
    },
    {
        path: '/panorama',
        children: [
            {
                path: '',
                name: 'panorama',
                component: () => import('../../vue/view/panorama/PanoramaView.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'cadastrar-despesa',
                name: 'panoramaRegister',
                component: () => import('../../vue/view/panorama/PanoramaForm.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: ':id/atualizar-despesa',
                name: 'panoramaUpdate',
                component: () => import('../../vue/view/panorama/PanoramaForm.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'todas-despesas-e-ganhos',
                name: 'manageAllSpentAndGain',
                component: () => import('../../vue/view/panorama/PanoramaAllSpentAndGain.vue'),
                meta: {
                    auth: true
                }
            }
        ]
    },
    {
        path: '/ganhos-futuros',
        children: [
            {
                path: '',
                name: 'futureGainList',
                component: () => import('../../vue/view/futureGain/FutureGainView.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'cadastrar',
                name: 'futureGainRegister',
                component: () => import('../../vue/view/futureGain/FutureGainForm.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: ':id/atualizar',
                name: 'futureGainUpdate',
                component: () => import('../../vue/view/futureGain/FutureGainForm.vue'),
                meta: {
                    auth: true
                }
            }
        ]
    },
    {
        path: '/carteiras',
        children: [
            {
                path: '',
                name: 'walletList',
                component: () => import('../../vue/view/wallet/WalletView.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'cadastrar',
                name: 'walletRegister',
                component: () => import('../../vue/view/wallet/WalletFormView.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: ':id/atualizar',
                name: 'walletUpdate',
                component: () => import('../../vue/view/wallet/WalletFormView.vue'),
                meta: {
                    auth: true
                }
            }
        ]
    },
    {
        path: '/gerenciar-cartoes',
        children: [
            {
                path: '',
                name: 'manageCards',
                component: () => import('../../vue/view/creditCard/ManageCardsView.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'cadastrar',
                name: 'manageCardsRegister',
                component: () => import('../../vue/view/creditCard/ManageCardsFormView.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: ':id/atualizar',
                name: 'manageCardsUpdate',
                component: () => import('../../vue/view/creditCard/ManageCardsFormView.vue'),
                meta: {
                    auth: true
                }
            }
        ]
    },
    {
        path: '/gerenciar-cartoes/despesa',
        children: [
            {
                path: 'cadastrar',
                name: 'manageCardsExpenseRegister',
                component: () => import('../../vue/view/creditCard/expense/CreditCardExpenseForm.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: ':cardId/cadastrar',
                name: 'manageCardsExpenseRegisterWithCard',
                component: () => import('../../vue/view/creditCard/expense/CreditCardExpenseForm.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: ':id/atualizar',
                name: 'manageCardsExpenseUpdate',
                component: () => import('../../vue/view/creditCard/expense/CreditCardExpenseForm.vue'),
                meta: {
                    auth: true
                }
            }
        ]
    },
    {
        path: '/gerenciar-cartoes/fatura-cartao',
        children: [
            {
                path: ':id',
                name: 'creditCardsInvoices',
                component: () => import('../../vue/view/creditCard/invoice/CreditCardInvoiceView.vue'),
                meta: {
                    auth: true
                }
            }
        ]
    },
    {
        path: '/ferramentas',
        children: [
            {
                path: '',
                name: 'tools',
                component: () => import('../../vue/view/tools/ToolsView.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'calculadora-salario',
                name: 'salaryCalculator',
                component: () => import('../../vue/view/tools/salaryCalculator/SalaryCalculator.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'calculadora-horas-extras',
                name: 'extraHoursCalculator',
                component: () => import('../../vue/view/tools/extraHoursCalculator/ExtraHoursCalculator.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'saude-financeira',
                name: 'financialHealth',
                component: () => import('../../vue/view/tools/financialHealth/FinancialHealthView.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'fechamento-mensal',
                name: 'monthlyClosing',
                component: () => import('../../vue/view/tools/monthlyClosing/MonthlyClosingView.vue'),
                meta: {
                    auth: true
                }
            }
        ]
    },
    {
        path: '/investimentos',
        children: [
            {
                path: '',
                name: 'investments',
                component: () => import('../../vue/view/investment/InvestmentView.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'cdb/cadastrar',
                name: 'registerInvestments',
                component: () => import('../../vue/view/investment/InvestmentForm.vue'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'cdb/:id/atualizar',
                name: 'updateInvestments',
                component: () => import('../../vue/view/investment/InvestmentForm.vue'),
                meta: {
                    auth: true
                }
            }
        ]
    },
    {
        path: '/configuracoes',
        name: 'configurations',
        component: () => import('../../vue/view/configurations/ConfigurationsView.vue'),
        meta: {
            auth: true
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('../../vue/view/PageNotFoundView.vue'),
        meta: {
            auth: false
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach(routesControl)

export default router