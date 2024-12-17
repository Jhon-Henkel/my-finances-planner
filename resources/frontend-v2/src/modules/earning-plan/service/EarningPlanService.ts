import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {useFutureProfitsStore} from "@/modules/future-profits/store/FutureProfitsStore"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import {IFutureProfitForm} from "@/modules/future-profits/service/IFutureProfitForm"
import {FutureProfitsModel} from "@/modules/future-profits/model/FutureProfitsModel"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import EarningPlanApiGetDto from "@/modules/earning-plan/dto/earning-plan.api.get.dto"
import {useEarningPlanStore} from "@/modules/earning-plan/store/EarningPlanStore"

export const EarningPlanService = {
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
    delete: async (data: EarningPlanApiGetDto): Promise<void> => {
        const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar o plano de receita?')
        const confirmDelete = await deleteConfirmAlert.open(`Deseja realmente excluir a receita ${data.description}?`)
        if (confirmDelete) {
            await ApiRouter.futureProfits.delete(data.id)
            const toast = new MfpToast()
            await toast.open('Plano de receita deletado com sucesso!')
            await EarningPlanService.reloadStore()
        }
    },
    reloadStore: async (): Promise<void> => {
        const store = useEarningPlanStore()
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
