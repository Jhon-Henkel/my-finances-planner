import {useCreditCardInvoiceStore} from "@/modules/credit-card/store/CreditCardInvoiceStore"

export const CreditCardInvoiceService = {
    reloadStore: async (cardId: string|number): Promise<void> => {
        const store = useCreditCardInvoiceStore()
        await store.load(cardId)
    }
}
