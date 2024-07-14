import {defineStore} from "pinia"
import {IInvoice} from "@/services/invoice/IInvoice"
import {FutureProfitsService} from "@/services/future-profits/FutureProfitsService"

interface IFutureProfitsStoreState {
    futureProfits: Array<IInvoice>
    isLoaded: boolean,
    installmentSelected: number
}

export const useFutureProfitsStore = defineStore({
    id: 'future-profits',
    state: (): IFutureProfitsStoreState => ({
        futureProfits: [],
        isLoaded: false,
        installmentSelected: 0,
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
        },
        async load() {
            this.isLoaded = false
            this.futureProfits = await FutureProfitsService.index()
            this.isLoaded = true
        }
    }
})