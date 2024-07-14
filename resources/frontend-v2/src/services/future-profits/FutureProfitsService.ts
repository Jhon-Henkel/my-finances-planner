import {IInvoice} from "@/services/invoice/IInvoice"
import {ApiRouter} from "@/api/ApiRouter"
import {useFutureProfitsStore} from "@/stores/future-profits/FutureProfitsStore"
import {InvoiceModel} from "@/model/invoice/invoiceModel"
import {UtilCalendar} from "@/util/UtilCalendar"
import {IFutureProfitForm} from "@/services/future-profits/IFutureProfitForm"
import {FutureProfitsModel} from "@/model/future-profits/FutureProfitsModel"
import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/components/toast/MfpToast"

export const FutureProfitsService = {
    index: async (): Promise<Array<IInvoice>> => {
        const data = await ApiRouter.futureProfits.index()
        return data.map((item: any) => new InvoiceModel(item))
    },
    create: async (data: IFutureProfitForm, isFixProfit: boolean): Promise<void> => {
        if (isFixProfit) {
            data.installments = 0
        }
        data.forecast = data.forecast.slice(0, 10)
        await ApiRouter.futureProfits.post(data)
    },
    get: async (id: number): Promise<FutureProfitsModel> => {
        const data = await ApiRouter.futureProfits.get(id)
        return new FutureProfitsModel(data)
    },
    update: async (data: IFutureProfitForm, isFixProfit: boolean): Promise<void> => {
        if (isFixProfit) {
            data.installments = 0
        }
        data.forecast = data.forecast.slice(0, 10)
        await ApiRouter.futureProfits.put(data.id, data)
    },
    delete: async (data: IInvoice): Promise<void> => {
        const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar o plano de receita?')
        const confirmDelete = await deleteConfirmAlert.open(`Deseja realmente excluir a receita ${data.name}?`)
        if (confirmDelete) {
            await ApiRouter.futureProfits.delete(data.id)
            const toast = new MfpToast()
            await toast.open('Plano de receita deletado com sucesso!')
            await FutureProfitsService.forceLoadStore()
        }
    },
    forceLoadStore: async (): Promise<void> => {
        const store = useFutureProfitsStore()
        store.loadAgainOnNextTick()
        await store.load()
    },
    makeEmptyFutureProfit: (): IFutureProfitForm => {
        return {
            id: null,
            description: '',
            amount: 0,
            walletId: 0,
            forecast: UtilCalendar.getTodayIso(),
            installments: 1
        }
    }
}