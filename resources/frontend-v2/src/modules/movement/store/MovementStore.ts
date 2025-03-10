import {defineStore} from 'pinia'
import {MovementModel} from "@/modules/movement/model/MovementModel"
import {MovementService} from "@/modules/movement/service/MovementService"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"

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
    thisMonthTotalBalance: number
    originalThisMonthTotalIncomesValue: number
    originalThisMonthTotalExpensesValue: number
    originalThisMonthTotalBalance: number
    dateOfResults: string
    marketPlannerDetails: {
        total_limit: number
        this_month_spent: number
        this_month_remaining_limit: number,
        percent_used: number,
        use_market_planner: boolean
    }
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
        originalThisMonthTotalIncomesValue: 0,
        originalThisMonthTotalExpensesValue: 0,
        originalThisMonthTotalBalance: 0,
        thisMonthTotalIncomesValue: 0,
        thisMonthTotalExpensesValue: 0,
        thisMonthTotalBalance: 0,
        totalBalanceValue: 0,
        dateOfResults: '',
        marketPlannerDetails: {
            total_limit: 0,
            this_month_spent: 0,
            this_month_remaining_limit: 0,
            percent_used: 0,
            use_market_planner: false
        }
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
        },
        async loadMovements(quest: string | null = null): Promise<Array<MovementModel>> {
            const questIsNull = quest === null
            if (! quest) {
                quest = `type=${MovementService.allType}`
            }
            if (!this.isLoaded) {
                this.isLoaded = false
                const request = await ApiRouter.movement.index(quest)
                this.movements = this.originalMovements = request.data.map((item: any) => new MovementModel(item))
                this.isLoaded = true
                this.dateOfResults = request.meta.date_label
                this.totalBalanceValue = this.originalThisMonthTotalBalance = request.meta.total_month
                this.totalExpensesValue = this.originalThisMonthTotalExpensesValue = request.meta.total_month_spent
                this.totalIncomesValue = this.originalThisMonthTotalIncomesValue = request.meta.total_month_gain
                if (questIsNull) {
                    this.thisMonthMovements = this.movements
                    this.thisMonthTotalIncomesValue = this.totalIncomesValue
                    this.thisMonthTotalExpensesValue = this.totalExpensesValue
                    this.thisMonthTotalBalance = this.totalBalanceValue
                }
                this.marketPlannerDetails = await MovementService.getMarketPlannerDetails()
                this.marketPlannerDetails.percent_used = this.marketPlannerDetails.this_month_spent / this.marketPlannerDetails.total_limit
            }
            return this.movements
        },
        setLastMovementFilterType(filter: number) {
            this.lastMovementFilterType = filter
        },
        filterMovementsOnStore(query: string|null) {
            this.movements = this.originalMovements
            this.thisMonthTotalBalance = this.originalThisMonthTotalBalance
            this.thisMonthTotalExpensesValue = this.originalThisMonthTotalExpensesValue
            this.thisMonthTotalIncomesValue = this.originalThisMonthTotalIncomesValue
            if (!query) {
                return
            }
            query = query.toLowerCase()
            this.movements = this.movements.filter(
                movement =>
                    movement.description.toLowerCase().includes(query)
                    || movement.walletName && movement.walletName.toLowerCase().includes(query)
            )
            const totals = MovementService.sumTotalValues(this.movements)
            this.totalIncomesValue = totals.incomes
            this.totalExpensesValue = totals.expenses
            this.totalBalanceValue = totals.balance
        }
    },
    getters: {
        isLoadedOnStore(): boolean {
            return this.isLoaded
        }
    }
})
