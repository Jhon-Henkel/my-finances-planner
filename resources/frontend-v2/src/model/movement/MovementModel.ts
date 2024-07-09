export class MovementModel {
    id: number
    description: string
    walletName: string
    type: number
    walletId: number
    amount: number
    createdAt: string

    constructor(data: any) {
        this.id = data.id
        this.description = data.description
        this.walletName = data.walletName
        this.type = data.type
        this.walletId = data.walletId
        this.amount = data.amount
        this.createdAt = data.createdAt
    }
}