import {defineStore} from "pinia"
import {CardsService} from "@/modules/credit-cards/service/CardsService"
import {CardModel} from "@/modules/credit-cards/model/CardModel"

interface ICardsStoreState {
    cards: Array<CardModel>
    isLoaded: boolean,
}

export const useCardsStore = defineStore({
    id: 'cards',
    state: (): ICardsStoreState => ({
        cards: [],
        isLoaded: false,
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
        },
        async load() {
            this.isLoaded = false
            this.cards = await CardsService.index()
            this.isLoaded = true
        }
    }
})
