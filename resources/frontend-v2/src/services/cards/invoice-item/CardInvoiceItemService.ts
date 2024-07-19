import {CardInvoiceItemModel} from "@/model/card/invoice-item/CardInvoiceItemModel"
import {UtilCalendar} from "@/util/UtilCalendar"
import {ApiRouter} from "@/api/ApiRouter"
import {useCardInvoicesStore} from "@/stores/cards/invoice/CardInvoiceStore"
import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/components/toast/MfpToast"
import {PanoramaService} from "@/services/panorama/PanoramaService"
import {CardsService} from "@/services/cards/CardsService"
import {InvoiceModel} from "@/model/invoice/invoiceModel"

export const CardInvoiceItemService = {
    create: async (data: CardInvoiceItemModel, isFixInstallment: boolean): Promise<void> => {
        if (isFixInstallment) {
            data.installments = 0
        }
        data.nextInstallment = data.nextInstallment.slice(0, 10)
        await ApiRouter.cards.invoices.post(data)
    },
    update: async (data: CardInvoiceItemModel, isFixInstallment: boolean): Promise<void> => {
        if (isFixInstallment) {
            data.installments = 0
        }
        data.nextInstallment = data.nextInstallment.slice(0, 10)
        await ApiRouter.cards.invoices.put(data.id, data)
    },
    get: async (id: number): Promise<CardInvoiceItemModel> => {
        const data = await ApiRouter.cards.invoices.get(id)
        return new CardInvoiceItemModel(data)
    },
    delete: async (data: InvoiceModel, cardId: number): Promise<void> => {
        const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar a parcela?')
        const confirmDelete = await deleteConfirmAlert.open(`Deseja realmente excluir a parcela ${data.name}?`)
        if (confirmDelete) {
            await ApiRouter.cards.invoices.delete(data.id)
            const toast = new MfpToast()
            await toast.open('Parcela deletada com sucesso!')
            await CardInvoiceItemService.forceReloadStore(cardId)
            await PanoramaService.forceReloadStore()
            await CardsService.forceReloadStore()
        }
    },
    makeEmptyInvoiceItem(): CardInvoiceItemModel {
        return {
            id: null,
            name: '',
            value: 0,
            creditCardId: 0,
            nextInstallment: UtilCalendar.getTodayIso(),
            installments: 1
        }
    },
    forceReloadStore: async (cardId: number|string): Promise<void> => {
        const store = useCardInvoicesStore()
        await store.load(cardId)
    }
}