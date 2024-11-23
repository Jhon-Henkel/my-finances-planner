import {AiInsightDto} from "@/modules/@shared/dto/ai/AiInsightModel"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"

interface IItem {
    name: string
    value: number
}

export class FinancialHealthModel {
    expenseItens: Array<IItem> = []
    incomeItens: Array<IItem> = []
    incomeTotalAmount: number = 0
    expenseTotalAmount: number = 0
    aiInsight: AiInsightDto = {
        type: 'unknown',
        insight: 'unknown',
        life_time_days: 0,
        created_at: UtilCalendar.getToday().toISOString()
    }
}
