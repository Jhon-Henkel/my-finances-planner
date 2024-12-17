import {IInvoice} from "@/modules/invoice/service/IInvoice"

export interface ISpendingPlanView {
    totalWalletValue: number
    futureExpenses: Array<IInvoice>
    totalFutureExpenses: IInvoice
    totalFutureGains: IInvoice
    totalCreditCardExpenses: IInvoice
    totalLeft: IInvoice
}
