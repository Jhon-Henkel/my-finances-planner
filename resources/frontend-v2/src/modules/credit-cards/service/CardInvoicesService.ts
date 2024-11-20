import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {InvoiceModel} from "@/model/invoice/invoiceModel"

export const CardInvoicesService = {
    index: async (cardId: number|string): Promise<Array<InvoiceModel>> => {
        const data = await ApiRouter.cards.invoices.index(cardId)
        return data.map((invoice: any) => new InvoiceModel(invoice))
    }
}
