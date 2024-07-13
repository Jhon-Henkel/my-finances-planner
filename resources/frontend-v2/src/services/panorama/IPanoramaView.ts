import {IInvoice} from "@/services/invoice/IInvoice"

export interface IPanoramaView {
    totalWalletValue: number
    futureExpenses: Array<IInvoice>
    totalFutureExpenses: IInvoice
    totalFutureGains: IInvoice
    totalCreditCardExpenses: IInvoice
    totalLeft: IInvoice
}