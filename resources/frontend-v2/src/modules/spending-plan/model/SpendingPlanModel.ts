export class SpendingPlanModel {
    id: number | null
    description: string
    amount: number
    walletId: number
    forecast: string
    installments: number
    bankSlipCode: null|string
    observations: string|undefined
    variableSpending: boolean

    constructor(data: any) {
        this.id = data.id
        this.description = data.description
        this.amount = data.amount
        this.walletId = data.walletId
        this.forecast = data.forecast
        this.installments = data.installments
        this.bankSlipCode = data?.bankSlipCode
        this.observations = data.observations == undefined ? '' : data.observations
        this.variableSpending = data.variable_spending == 1
    }
}
