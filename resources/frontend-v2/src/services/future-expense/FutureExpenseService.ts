import {IFutureExpenseForm} from "@/services/future-expense/IFutureExpenseForm"
import {UtilCalendar} from "@/util/UtilCalendar"
import {ApiRouter} from "@/api/ApiRouter"
import {FutureExpenseModel} from "@/model/future-expense/FutureExpenseModel"
import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/components/toast/MfpToast"
import {PanoramaService} from "@/services/panorama/PanoramaService"
import {IInvoice} from "@/services/invoice/IInvoice"

export const FutureExpenseService = {
    create: async (data: IFutureExpenseForm, isFixExpense: boolean): Promise<void> => {
        if (isFixExpense) {
            data.installments = 0
        }
        data.forecast = data.forecast.slice(0, 10)
        await ApiRouter.futureExpense.post(data)
    },
    get: async (id: number): Promise<FutureExpenseModel> => {
        const data = await ApiRouter.futureExpense.get(id)
        return new FutureExpenseModel(data)
    },
    update: async (data: IFutureExpenseForm, isFixExpense: boolean): Promise<void> => {
        if (isFixExpense) {
            data.installments = 0
        }
        data.forecast = data.forecast.slice(0, 10)
        await ApiRouter.futureExpense.put(data.id, data)
    },
    delete: async (data: IInvoice): Promise<void> => {
        const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar o plano de despesa?')
        const confirmDelete = await deleteConfirmAlert.open(`Deseja realmente excluir a despesa ${data.name}?`)
        if (confirmDelete) {
            await ApiRouter.futureExpense.delete(data.id)
            const toast = new MfpToast()
            await toast.open('Plano de despesa deletado com sucesso!')
            await PanoramaService.forceReloadStore()
        }
    },
    makeEmptyFutureExpense: (): IFutureExpenseForm => {
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