export class FutureExpensePayModel {
    value: number
    walletId: number
    partial: boolean

    constructor(value: number, walletId: number, partial: boolean) {
        this.value = value
        this.walletId = walletId
        this.partial = partial
    }
}
