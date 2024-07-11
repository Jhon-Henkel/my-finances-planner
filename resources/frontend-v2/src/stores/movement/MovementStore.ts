import {defineStore} from 'pinia'
import {MovementModel} from "@/model/movement/MovementModel"
import {MovementService} from "@/services/movement/MovementService"
import {UtilCalendar} from "@/util/UtilCalendar"

interface IMovementStoreState {
    movements: Array<MovementModel>
    isLoaded: boolean
    lastMovementFilterType: number
    totalIncomesValue: number
    totalExpensesValue: number
    totalBalanceValue: number
}

export const useMovementStore = defineStore({
    id: 'movement',
    state: (): IMovementStoreState => ({
        movements: [],
        isLoaded: false,
        lastMovementFilterType: MovementService.allType,
        totalIncomesValue: 0,
        totalExpensesValue: 0,
        totalBalanceValue: 0
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
        },
        async loadMovements(quest: string | null = null): Promise<Array<MovementModel>> {
            if (! quest) {
                const dateFilterString: string = UtilCalendar.makeStringFilterDate(UtilCalendar.getTodayIso())
                quest = `type=${MovementService.allType}&${dateFilterString}`
            }
            if (!this.isLoaded) {
                this.isLoaded = false
                this.movements = await MovementService.index(quest)
                this.isLoaded = true
                const totals = MovementService.sumTotalValues(this.movements)
                this.totalIncomesValue = totals.incomes
                this.totalExpensesValue = totals.expenses
                this.totalBalanceValue = totals.balance
            }
            return this.movements
        },
        setLastMovementFilterType(filter: number) {
            this.lastMovementFilterType = filter
        }
    },

    getters: {
        isLoadedOnStore(): boolean {
            return this.isLoaded
        },
        getMovements(): Array<MovementModel> {
            return this.movements
        }
    }
})