import {defineStore} from "pinia"
import {IInvoice} from "@/modules/invoice/service/IInvoice"
import {FutureProfitsService} from "@/modules/future-profits/service/FutureProfitsService"

interface IFutureProfitsStoreState {
    futureProfits: Array<IInvoice>
    isLoaded: boolean,
    installmentSelected: number
    thisMonthValue: number
}

export const useFutureProfitsStore = defineStore({
    id: 'future-profits',
    state: (): IFutureProfitsStoreState => ({
        futureProfits: [],
        isLoaded: false,
        installmentSelected: 0,
        thisMonthValue: 0
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
        },
        async load() {
            this.isLoaded = false
            this.futureProfits = await FutureProfitsService.index()
            this.futureProfits.forEach((invoice) => {
                this.thisMonthValue += invoice.firstInstallment
            })
            this.isLoaded = true
        }
    }
})
