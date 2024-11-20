import {defineStore} from "pinia"
import {IInvoice} from "@/services/invoice/IInvoice"
import {CardInvoicesService} from "@/modules/credit-cards/service/CardInvoicesService"

interface ICardInvoicesStoreState {
    invoice: Array<IInvoice>
    isLoaded: boolean,
    installmentSelected: number
}

export const useCardInvoicesStore = defineStore({
    id: 'card-invoices',
    state: (): ICardInvoicesStoreState => ({
        invoice: [],
        isLoaded: false,
        installmentSelected: 0
    }),
    actions: {
        async load(id: string|number) {
            this.isLoaded = false
            this.invoice = await CardInvoicesService.index(id)
            this.isLoaded = true
        }
    }
})
