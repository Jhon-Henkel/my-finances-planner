import {defineStore} from "pinia"
import {CardsService} from "@/services/cards/CardsService"
import {CardModel} from "@/model/card/CardModel"

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