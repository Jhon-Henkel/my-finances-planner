import {
    calendarNumberOutline,
    cardOutline,
    cashOutline,
    cogOutline,
    fitnessOutline,
    homeOutline,
    personCircleOutline,
    swapHorizontalOutline,
    walletOutline
} from "ionicons/icons"
import {RouteName} from "@/infra/router/routeName"

export const MenuItems = [
    {
        icon: homeOutline,
        routeName: 'dashboard',
        label: 'Inicio',
    },
    {
        icon: swapHorizontalOutline,
        routeName: 'movements',
        label: 'Movimentações',
    },
    {
        icon: calendarNumberOutline,
        routeName: 'panorama',
        label: 'Plano de Gastos',
    },
    {
        icon: cashOutline,
        routeName: RouteName.earning_plan,
        label: 'Plano de Receitas',
    },
    {
        icon: walletOutline,
        routeName: 'wallets',
        label: 'Carteiras',
    },
    {
        icon: cardOutline,
        routeName: 'manage-cards',
        label: 'Cartões',
    },
    {
        icon: fitnessOutline,
        routeName: 'financial-health',
        label: 'Saúde Financeira',
    },
    {
        icon: personCircleOutline,
        routeName: 'user-settings',
        label: 'Configurações do Usuário',
    },
    {
        icon: cogOutline,
        routeName: 'main-settings',
        label: 'Configurações Gerais',
    },
]
