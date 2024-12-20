import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {SpendingPlanService} from "@/modules/spending-plan/service/SpendingPlanService"
import {CreditCardInvoiceItemModel} from "@/modules/credit-card/model/CreditCardInvoiceItemModel"
import {useCreditCardInvoiceStore} from "@/modules/credit-card/store/CreditCardInvoiceStore"
import {CreditCardService} from "@/modules/credit-card/service/CreditCardService"
import ICreditCardInvoiceListDto from "@/modules/credit-card/dto/credit-card.invoice.list.dto"

export const CreditCardInvoiceItemService = {
    create: async (data: CreditCardInvoiceItemModel, isFixInstallment: boolean): Promise<void> => {
        if (isFixInstallment) {
            data.installments = 0
        }
        data.nextInstallment = data.nextInstallment.slice(0, 10)
        await ApiRouter.cards.invoices.post(data)
    },
    update: async (data: CreditCardInvoiceItemModel, isFixInstallment: boolean): Promise<void> => {
        if (isFixInstallment) {
            data.installments = 0
        }
        data.nextInstallment = data.nextInstallment.slice(0, 10)
        await ApiRouter.cards.invoices.put(data.id, data)
    },
    get: async (id: number): Promise<CreditCardInvoiceItemModel> => {
        const data = await ApiRouter.cards.invoices.get(id)
        return new CreditCardInvoiceItemModel(data)
    },
    delete: async (data: ICreditCardInvoiceListDto, cardId: number): Promise<void> => {
        const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar a parcela?')
        const confirmDelete = await deleteConfirmAlert.open(`Deseja realmente excluir a parcela ${data.description}?`)
        if (confirmDelete) {
            await ApiRouter.cards.invoices.delete(data.id)
            const toast = new MfpToast()
            await toast.open('Parcela deletada com sucesso!')
            await CreditCardInvoiceItemService.reloadStore(cardId)
            await SpendingPlanService.reloadStore()
            await CreditCardService.reloadStore()
        }
    },
    makeEmptyInvoiceItem(): CreditCardInvoiceItemModel {
        return {
            id: null,
            name: '',
            value: 0,
            creditCardId: 0,
            nextInstallment: UtilCalendar.getTodayIso(),
            installments: 1
        }
    },
    reloadStore: async (cardId: number|string|null): Promise<void> => {
        const store = useCreditCardInvoiceStore()
        await store.load(cardId)
    }
}
