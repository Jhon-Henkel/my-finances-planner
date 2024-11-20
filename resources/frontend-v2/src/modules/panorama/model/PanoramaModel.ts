import {IInvoice} from "@/modules/invoice/service/IInvoice"

export class PanoramaModel {
    totalWalletValue: number
    futureExpenses: Array<IInvoice>
    totalFutureExpenses: IInvoice
    totalFutureGains: IInvoice
    totalCreditCardExpenses: IInvoice
    totalLeft: IInvoice

    constructor(data: any) {
        this.totalWalletValue = data.totalWalletValue
        this.futureExpenses = data.futureExpenses
        this.totalFutureExpenses = data.totalFutureExpenses
        this.totalFutureGains = data.totalFutureGains
        this.totalCreditCardExpenses = data.totalCreditCardExpenses
        this.totalLeft = data.totalLeft
    }
}
