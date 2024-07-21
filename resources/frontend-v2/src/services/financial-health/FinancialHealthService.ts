import {ApiRouter} from "@/api/ApiRouter"
import {FinancialHealthModel} from "@/model/financial-health/FinancialHealthModel"

export const FinancialHealthService = {
    get: async (quest: null | string = null): Promise<FinancialHealthModel> => {
        const data = await ApiRouter.financialHealth.getFiltered(quest)
        return FinancialHealthService.populateApiForModel(data)
    },
    populateApiForModel: (data: any): FinancialHealthModel => {
        const expenses: Array<{name: string, value: number}> = []
        for (const [key, value] of Object.entries(data['5'])) {
            expenses.push({name: key, value: parseFloat(String(value))});
        }
        const incomes: Array<{name: string, value: number}> = []
        for (const [key, value] of Object.entries(data['6'])) {
            incomes.push({name: key, value: parseFloat(String(value))});
        }
        const item = new FinancialHealthModel()
        item.expenseItens = expenses
        item.incomeItens = incomes
        item.incomeTotalAmount = parseFloat(String(data['dataForGraph']['6']['total']))
        item.expenseTotalAmount = parseFloat(String(data['dataForGraph']['5']['total']))
        return item
    }
}