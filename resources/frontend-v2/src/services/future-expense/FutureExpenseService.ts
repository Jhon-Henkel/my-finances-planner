import {IFutureExpenseForm} from "@/services/future-expense/IFutureExpenseForm"
import {UtilCalendar} from "@/util/UtilCalendar"
import {ApiRouter} from "@/api/ApiRouter"

export const FutureExpenseService = {
    create: async (data: IFutureExpenseForm, isFixExpense: boolean): Promise<void> => {
        if (isFixExpense) {
            data.installments = 0
        }
        data.forecast = data.forecast.slice(0, 10)
        await ApiRouter.futureExpense.post(data)
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