import {defineStore} from "pinia"
import ICreditCardInvoiceListDto from "@/modules/credit-card/dto/credit-card.invoice.list.dto"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {ResponseListDefault} from "@/infra/response/response.list.default"

interface ICreditCardInvoiceStoreState {
    invoice: Array<ICreditCardInvoiceListDto>
    isLoaded: boolean,
    installmentSelected: number,
    monthTotalAmount: number,
    nextMonthUrl: string,
    prevMonthUrl: string,
    dateLabel: string,
    pageTotalItems: number
    lastCardId: number|string|null
}

export const useCreditCardInvoiceStore = defineStore('credit-card-invoice', {
    state: (): ICreditCardInvoiceStoreState => ({
        invoice: [],
        isLoaded: false,
        installmentSelected: 0,
        pageTotalItems: 0,
        monthTotalAmount: 0,
        nextMonthUrl: '',
        prevMonthUrl: '',
        dateLabel: '',
        lastCardId: null
    }),
    actions: {
        async load(cardId: string|number|null) {
            if (cardId == null && this.lastCardId !== null) {
                cardId = this.lastCardId
            }
            this.isLoaded = false
            this._storeData(await ApiRouter.cards_v2.invoices.index(cardId))
            this.isLoaded = true
            this.lastCardId = cardId
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
            this.invoice = data.data
            this.monthTotalAmount = data.meta.total_month_amount
            this.dateLabel = data.meta.date_label
            this.pageTotalItems = data.page.total
            this.nextMonthUrl = data.links.next
            this.prevMonthUrl = data.links.prev
        }
    }
})
