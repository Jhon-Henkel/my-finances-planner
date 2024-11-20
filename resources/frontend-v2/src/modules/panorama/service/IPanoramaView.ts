import {IInvoice} from "@/modules/invoice/service/IInvoice"

export interface IPanoramaView {
    totalWalletValue: number
    futureExpenses: Array<IInvoice>
    totalFutureExpenses: IInvoice
    totalFutureGains: IInvoice
    totalCreditCardExpenses: IInvoice
    totalLeft: IInvoice
}
