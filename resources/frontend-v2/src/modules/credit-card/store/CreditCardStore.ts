import {defineStore} from "pinia"
import {CreditCardModel} from "@/modules/credit-card/model/CreditCardModel"
import {CreditCardService} from "@/modules/credit-card/service/CreditCardService"

interface ICreditCardStoreState {
    cards: Array<CreditCardModel>
    isLoaded: boolean,
    pageTotalItems: number,
    activeCards: Array<CreditCardModel>
    inactiveCards: Array<CreditCardModel>
}

export const useCreditCardStore = defineStore('credit-card', {
    state: (): ICreditCardStoreState => ({
        cards: [],
        isLoaded: false,
        pageTotalItems: 0,
        activeCards: [],
        inactiveCards: []
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
            this.inactiveCards = []
            this.activeCards = []
            for (let i = 0; i < this.cards.length; i++) {
                if (this.cards[i].active) {
                    this.activeCards.push(this.cards[i])
                } else {
                    this.inactiveCards.push(this.cards[i])
                }
            }
            this.isLoaded = true
        },
        searchCard(id: number): CreditCardModel | undefined {
            return this.cards.find(card => card.id === id)
        }
    }
})
