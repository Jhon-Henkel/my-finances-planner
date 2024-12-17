import {defineStore} from "pinia"
import {ResponseListDefault} from "@/infra/response/response.list.default"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import EarningPlanApiGetDto from "@/modules/earning-plan/dto/earning-plan.api.get.dto"

interface IEarningPlanStoreState {
    earningPlan: Array<EarningPlanApiGetDto>
    monthTotalAmount: number,
    nextMonthUrl: string,
    prevMonthUrl: string,
    dateLabel: string,
    isLoaded: boolean,
    pageTotalItems: number,
    dateSearch: string
}

export const useEarningPlanStore = defineStore('earning-plan', {
    state: (): IEarningPlanStoreState => ({
        earningPlan: [],
        monthTotalAmount: 0,
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
            this._storeData(await ApiRouter.earning_plan.index())
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
            this.dateLabel = data.meta.date_label
            this.earningPlan = data.data
            this.pageTotalItems = data.page.total
            this.nextMonthUrl = data.links.next
            this.prevMonthUrl = data.links.prev
            this.dateSearch = data.meta.search_date
        },
        isAllowedToProcess(): boolean {
            // todo - definir regra
            return false
        }
    }
})
