import {defineStore} from 'pinia'
import {FinancialHealthModel} from "@/modules/financial-health/model/FinancialHealthModel"
import {FinancialHealthService} from "@/modules/financial-health/service/FinancialHealthService"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"

interface IFinancialHealthStoreState {
    items: FinancialHealthModel
    isLoaded: boolean,
    monthSelected: number
    groupCards: boolean
    dateFilter: string
}

export const useFinancialHealthStore = defineStore({
    id: 'financial-health',
    state: (): IFinancialHealthStoreState => ({
        items: new FinancialHealthModel(),
        isLoaded: false,
        monthSelected: UtilCalendar.getToday().getMonth(),
        groupCards: false,
        dateFilter: UtilCalendar.getTodayIso()
    }),
    actions: {
        async load(quest: string|null = null): Promise<void> {
            if (!quest) {
                const dateFilter: string = UtilCalendar.makeStringFilterDate(UtilCalendar.getTodayIso())
                quest = `${dateFilter}&type=0`
                this.monthSelected = UtilCalendar.getToday().getMonth()
            }
            this.isLoaded = false
            this.items = await FinancialHealthService.get(quest)
            this.isLoaded = true
        }
    }
})
