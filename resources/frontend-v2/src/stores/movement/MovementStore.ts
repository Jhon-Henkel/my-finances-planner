import {defineStore} from 'pinia'
import {MovementModel} from "@/model/movement/MovementModel"
import {MovementService} from "@/services/movement/MovementService"
import {UtilCalendar} from "@/util/UtilCalendar"

interface IMovementStoreState {
    movements: Array<MovementModel>
    originalMovements: Array<MovementModel>
    thisMonthMovements: Array<MovementModel>
    isLoaded: boolean
    lastMovementFilterType: number
    totalIncomesValue: number
    totalExpensesValue: number
    totalBalanceValue: number
    thisMonthTotalIncomesValue: number
    thisMonthTotalExpensesValue: number
    dateOfResults: string
}

export const useMovementStore = defineStore({
    id: 'movement',
    state: (): IMovementStoreState => ({
        movements: [],
        originalMovements: [],
        thisMonthMovements: [],
        isLoaded: false,
        lastMovementFilterType: MovementService.allType,
        totalIncomesValue: 0,
        totalExpensesValue: 0,
        thisMonthTotalIncomesValue: 0,
        thisMonthTotalExpensesValue: 0,
        totalBalanceValue: 0,
        dateOfResults: ''
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
        },
        async loadMovements(quest: string | null = null): Promise<Array<MovementModel>> {
            const questIsNull = quest === null
            if (! quest) {
                const dateFilterString: string = UtilCalendar.makeStringFilterDate(UtilCalendar.getTodayIso())
                quest = `type=${MovementService.allType}&${dateFilterString}`
            }
            if (!this.isLoaded) {
                this.isLoaded = false
                this.movements = this.originalMovements = await MovementService.index(quest)
                this.isLoaded = true
                this.dateOfResults = UtilCalendar.makeLabelFilterDate(quest)
                const totals = MovementService.sumTotalValues(this.movements)
                this.totalIncomesValue = totals.incomes
                this.totalExpensesValue = totals.expenses
                this.totalBalanceValue = totals.balance
                if (questIsNull) {
                    this.thisMonthMovements = this.movements
                    this.thisMonthTotalIncomesValue = this.totalIncomesValue
                    this.thisMonthTotalExpensesValue = this.totalExpensesValue
                }
            }
            return this.movements
        },
        setLastMovementFilterType(filter: number) {
            this.lastMovementFilterType = filter
        },
        filterMovementsOnStore(query: string|null) {
            this.movements = this.originalMovements
            if (!query) {
                return
            }
            query = query.toLowerCase()
            this.movements = this.movements.filter(
                movement =>
                    movement.description.toLowerCase().includes(query)
                    || movement.walletName && movement.walletName.toLowerCase().includes(query)
            )
        }
    },
    getters: {
        isLoadedOnStore(): boolean {
            return this.isLoaded
        }
    }
})