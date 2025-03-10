import {defineStore} from 'pinia'
import {MovementModel} from "@/modules/movement/model/MovementModel"
import {MovementService} from "@/modules/movement/service/MovementService"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {ResponseListDefault} from "@/infra/response/response.list.default"

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
    },
    nextMonthUrl: string
    prevMonthUrl: string
    dateLabel: string
    pageTotalItems: number
    dateSearch: string
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
        },
        nextMonthUrl: '',
        prevMonthUrl: '',
        dateLabel: '',
        pageTotalItems: 0,
        dateSearch: ''
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
        },
        async loadMovements(quest: string | null = null): Promise<Array<MovementModel>> {
            if (! quest) {
                quest = `type=${MovementService.allType}`
            }
            if (!this.isLoaded) {
                this.isLoaded = false
                await this._storeData(await ApiRouter.movement.index(quest))
                this.isLoaded = true
            }
            return this.movements
        },
        async nextMonth() {
            if (this.nextMonthUrl == '') {
                return
            }
            this.isLoaded = false
            await this._storeData(await ApiRouter.genericListRequestWithAuth(this.nextMonthUrl))
            this.isLoaded = true
        },
        async prevMonth() {
            if (this.prevMonthUrl == '') {
                return
            }
            this.isLoaded = false
            await this._storeData(await ApiRouter.genericListRequestWithAuth(this.prevMonthUrl))
            this.isLoaded = true
        },
        async _storeData(request: ResponseListDefault) {
            this.movements = this.originalMovements = request.data.map((item: any) => new MovementModel(item))
            this.isLoaded = true
            this.dateOfResults = request.meta.date_label
            this.totalBalanceValue = this.originalThisMonthTotalBalance = request.meta.total_month
            this.totalExpensesValue = this.originalThisMonthTotalExpensesValue = request.meta.total_month_spent
            this.totalIncomesValue = this.originalThisMonthTotalIncomesValue = request.meta.total_month_gain
            this.dateLabel = request.meta.date_label
            this.pageTotalItems = request.page.total
            this.nextMonthUrl = request.links.next
            this.prevMonthUrl = request.links.prev
            this.dateSearch = request.meta.search_date
            this.thisMonthMovements = this.movements
            this.thisMonthTotalIncomesValue = this.totalIncomesValue
            this.thisMonthTotalExpensesValue = this.totalExpensesValue
            this.thisMonthTotalBalance = this.totalBalanceValue
            this.marketPlannerDetails = await MovementService.getMarketPlannerDetails()
            this.marketPlannerDetails.percent_used = this.marketPlannerDetails.this_month_spent / this.marketPlannerDetails.total_limit
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
