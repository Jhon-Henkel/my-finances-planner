export class PayReceiveModel {
    value: number
    walletId: number
    partial: boolean

    constructor(value: number|string, walletId: number, partial: boolean) {
        this.value = value
        this.walletId = walletId
        this.partial = partial
    }
}
