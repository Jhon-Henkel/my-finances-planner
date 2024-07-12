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
        icon: calendarOutline,
        routeName: 'in-development',
        label: 'Balanço Mensal (Em Desenvolvimento)',
    },
    {
        icon: swapHorizontalOutline,
        routeName: 'movements',
        label: 'Movimentações',
    },
    {
        icon: cashOutline,
        routeName: 'in-development',
        label: 'Receitas Futuras (Em Desenvolvimento)',
    },
    {
        icon: walletOutline,
        routeName: 'wallets',
        label: 'Carteiras',
    },
    {
        icon: cardOutline,
        routeName: 'in-development',
        label: 'Cartões (Em Desenvolvimento)',
    },
    {
        icon: settingsOutline,
        routeName: 'in-development',
        label: 'Configurações (Em Desenvolvimento)',
    }
]