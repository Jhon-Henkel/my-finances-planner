export interface ISpendingPlanForm {
    id: any
    description: string
    walletId: number
    forecast: string
    amount: number
    installments: number
    bankSlipCode: string | null
    observations: string | undefined
    variableSpending: boolean|number
}
