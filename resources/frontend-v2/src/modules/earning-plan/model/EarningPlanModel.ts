export class EarningPlanModel {
    id: number | null
    description: string
    amount: number
    walletId: number
    forecast: string
    installments: number

    constructor(data: any) {
        this.id = data.id
        this.description = data.description
        this.amount = data.amount
        this.walletId = data.walletId
        this.forecast = data.forecast
        this.installments = data.installments
    }
}
