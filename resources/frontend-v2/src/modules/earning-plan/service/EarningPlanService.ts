import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import EarningPlanApiGetDto from "@/modules/earning-plan/dto/earning-plan.api.get.dto"
import {useEarningPlanStore} from "@/modules/earning-plan/store/EarningPlanStore"
import {EarningPlanModel} from "@/modules/earning-plan/model/EarningPlanModel"
import {IEarningPlanForm} from "@/modules/earning-plan/service/IEarningPlanForm"

export const EarningPlanService = {
    create: async (data: IEarningPlanForm, isFixProfit: boolean): Promise<void> => {
        if (isFixProfit) {
            data.installments = 0
        }
        data.forecast = data.forecast.slice(0, 10)
        await ApiRouter.futureProfits.post(data)
    },
    get: async (id: number): Promise<EarningPlanModel> => {
        const data = await ApiRouter.futureProfits.get(id)
        return new EarningPlanModel(data)
    },
    update: async (data: IEarningPlanForm, isFixProfit: boolean): Promise<void> => {
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
    makeEmptyFutureProfit: (): IEarningPlanForm => {
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
