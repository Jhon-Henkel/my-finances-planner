export class WalletModel {
    id: any
    name: string
    amount: number

    constructor(data: any) {
        this.id = data.id
        this.name = data.name
        this.amount = data.amount
    }
}