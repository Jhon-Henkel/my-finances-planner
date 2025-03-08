import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import SpendingPlanApiGetDto from "@/modules/spending-plan/dto/spending-plan.api.get.dto"
import {ISpendingPlanForm} from "@/modules/spending-plan/model/ISpendingPlanForm"
import {SpendingPlanModel} from "@/modules/spending-plan/model/SpendingPlanModel"
import {useSpendingPlanStore} from "@/modules/spending-plan/store/SpendingPlanStore"

export const SpendingPlanService = {
    create: async (data: ISpendingPlanForm, isFixExpense: boolean): Promise<void> => {
        if (isFixExpense) {
            data.installments = 0
        }
        data.forecast = data.forecast.slice(0, 10)
        await ApiRouter.spending_plan.post(data)
    },
    get: async (id: number): Promise<SpendingPlanModel> => {
        const data = await ApiRouter.spending_plan.get(id)
        return new SpendingPlanModel(data)
    },
    update: async (data: ISpendingPlanForm, isFixExpense: boolean): Promise<void> => {
        if (isFixExpense) {
            data.installments = 0
        }
        data.forecast = data.forecast.slice(0, 10)
        await ApiRouter.spending_plan.put(data.id, data)
    },
    delete: async (data: SpendingPlanApiGetDto): Promise<void> => {
        const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar o plano de despesa?')
        const confirmDelete = await deleteConfirmAlert.open(`Deseja realmente excluir a despesa ${data.description}?`)
        if (confirmDelete) {
            await ApiRouter.futureExpense.delete(data.id)
            const toast = new MfpToast()
            await toast.open('Plano de despesa deletado com sucesso!')
            await SpendingPlanService.reloadStore()
        }
    },
    makeEmptySpendingPlan: (): ISpendingPlanForm => {
        return {
            id: null,
            description: '',
            amount: 0,
            walletId: 0,
            forecast: UtilCalendar.getTodayIso(),
            installments: 1,
            bankSlipCode: null,
        }
    },
    reloadStore: async () => {
        const store = useSpendingPlanStore()
        await store.load()
    }
}
