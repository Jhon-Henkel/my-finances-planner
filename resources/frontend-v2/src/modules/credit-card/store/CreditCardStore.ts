import {defineStore} from "pinia"
import {CreditCardModel} from "@/modules/credit-card/model/CreditCardModel"
import {CreditCardService} from "@/modules/credit-card/service/CreditCardService"

interface ICreditCardStoreState {
    cards: Array<CreditCardModel>
    isLoaded: boolean,
    pageTotalItems: number
}

export const useCreditCardStore = defineStore('credit-card', {
    state: (): ICreditCardStoreState => ({
        cards: [],
        isLoaded: false,
        pageTotalItems: 0
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
        },
        async load() {
            this.isLoaded = false
            const items = await CreditCardService.index()
            this.cards = items
            this.pageTotalItems = items.length
            this.isLoaded = true
        }
    }
})
