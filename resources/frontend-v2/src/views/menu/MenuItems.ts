import {
    calendarOutline,
    cardOutline,
    cashOutline,
    homeOutline, settingsOutline,
    swapHorizontalOutline,
    walletOutline
} from "ionicons/icons"

export const MenuItems = [
    {
        icon: homeOutline,
        routeName: 'in-development',
        label: 'Inicio (Em Desenvolvimento)',
    },
    {
        icon: swapHorizontalOutline,
        routeName: 'movements',
        label: 'Movimentações',
    },
    {
        icon: calendarOutline,
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
        icon: settingsOutline,
        routeName: 'in-development',
        label: 'Configurações (Em Desenvolvimento)',
    }
]