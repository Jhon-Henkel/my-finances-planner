import {
    calendarNumberOutline,
    cardOutline,
    cashOutline,
    homeOutline,
    personCircleOutline,
    swapHorizontalOutline,
    walletOutline
} from "ionicons/icons"

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
        routeName: 'future-profits',
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
        icon: personCircleOutline,
        routeName: 'user-settings',
        label: 'Configurações do Usuário',
    }
]