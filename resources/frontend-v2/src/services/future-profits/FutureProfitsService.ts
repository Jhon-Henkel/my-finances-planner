import {IInvoice} from "@/services/invoice/IInvoice"
import {ApiRouter} from "@/api/ApiRouter"
import {FutureProfitsModel} from "@/model/future-profits/FutureProfitsModel"
import {useFutureProfitsStore} from "@/stores/future-profits/FutureProfitsStore"

export const FutureProfitsService = {
    index: async (): Promise<Array<IInvoice>> => {
        const data = await ApiRouter.futureProfits.index()
        return data.map((item: any) => new FutureProfitsModel(item))
    },
    forceLoadStore: async (): Promise<void> => {
        const store = useFutureProfitsStore()
        store.loadAgainOnNextTick()
        await store.load()
    }
}