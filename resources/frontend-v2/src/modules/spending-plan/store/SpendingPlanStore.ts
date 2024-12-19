import {defineStore} from "pinia"
import SpendingPlanApiGetDto from "@/modules/spending-plan/dto/spending-plan.api.get.dto"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {ResponseListDefault} from "@/infra/response/response.list.default"

interface ISpendingPlanState {
    spendingPlan: Array<SpendingPlanApiGetDto>
    monthTotalAmount: number,
    thisMonthTotalAmount: number,
    walletTotalAmount: number,
    earningsTotalAmount: number,
    earningsThisMonthTotalAmount: number,
    creditCardsTotalAmount: number,
    creditCardsThisMonthTotalAmount: number,
    nextMonthUrl: string,
    prevMonthUrl: string,
    dateLabel: string,
    isLoaded: boolean,
    pageTotalItems: number,
    dateSearch: string
}

export const useSpendingPlanStore = defineStore('spending-plan', {
    state: (): ISpendingPlanState => ({
        spendingPlan: [],
        monthTotalAmount: 0,
        thisMonthTotalAmount: 0,
        walletTotalAmount: 0,
        earningsTotalAmount: 0,
        earningsThisMonthTotalAmount: 0,
        creditCardsTotalAmount: 0,
        creditCardsThisMonthTotalAmount: 0,
        nextMonthUrl: '',
        prevMonthUrl: '',
        dateLabel: '',
        isLoaded: false,
        pageTotalItems: 0,
        dateSearch: ''
    }),
    actions: {
        async load() {
            this.isLoaded = false
            this._storeData(await ApiRouter.spending_plan.index())
            this.earningsThisMonthTotalAmount = this.earningsTotalAmount
            this.thisMonthTotalAmount = this.monthTotalAmount
            this.creditCardsThisMonthTotalAmount = this.creditCardsTotalAmount
            this.isLoaded = true
        },
        async nextMonth() {
            if (this.nextMonthUrl == '') {
                return
            }
            this.isLoaded = false
            this._storeData(await ApiRouter.genericListRequestWithAuth(this.nextMonthUrl))
            this.isLoaded = true
        },
        async prevMonth() {
            if (this.prevMonthUrl == '') {
                return
            }
            this.isLoaded = false
            this._storeData(await ApiRouter.genericListRequestWithAuth(this.prevMonthUrl))
            this.isLoaded = true
        },
        _storeData(data: ResponseListDefault) {
            this.monthTotalAmount = data.meta.total_month_amount
            this.walletTotalAmount = data.meta.total_wallet_amount
            this.earningsTotalAmount = data.meta.total_earnings_amount
            this.creditCardsTotalAmount = data.meta.total_credit_cards_amount
            this.dateLabel = data.meta.date_label
            this.spendingPlan = data.data
            this.pageTotalItems = data.page.total
            this.nextMonthUrl = data.links.next
            this.prevMonthUrl = data.links.prev
            this.dateSearch = data.meta.search_date
        }
    }
})
