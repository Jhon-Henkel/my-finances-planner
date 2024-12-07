export class WalletModel {
    id: any
    name: string
    amount: number
    hideValue: boolean

    constructor(data: any) {
        this.id = data.id
        this.name = data.name
        this.amount = data.amount
        this.hideValue = data.hideValue
    }
}
