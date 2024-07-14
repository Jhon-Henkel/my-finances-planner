import {ApiRouter} from "@/api/ApiRouter"
import {PanoramaModel} from "@/model/panorama/PanoramaModel"
import {IPanoramaView} from "@/services/panorama/IPanoramaView"
import {usePanoramaStore} from "@/stores/panorama/PanoramaStore"
import {InvoiceModel} from "@/model/invoice/invoiceModel"

export const PanoramaService = {
    index: async (): Promise<IPanoramaView> => {
        const data = await ApiRouter.panorama.index()
        return new PanoramaModel(data)
    },
    forceReloadStore: async () => {
        const store = usePanoramaStore()
        store.loadAgainOnNextTick()
        await store.load()
    },
    getNextInstallmentValue: (item: InvoiceModel): number => {
        if (item.firstInstallment > 0) {
            return item.firstInstallment
        } else if (item.secondInstallment > 0) {
            return item.secondInstallment
        } else if (item.thirdInstallment > 0) {
            return item.thirdInstallment
        } else if (item.fourthInstallment > 0) {
            return item.fourthInstallment
        } else if (item.fifthInstallment > 0) {
            return item.fifthInstallment
        } else if (item.sixthInstallment > 0) {
            return item.sixthInstallment
        }
        return 0
    },
    getNumberOfNextInvoice: (item: InvoiceModel): number => {
        if (item.firstInstallment > 0) {
            return 1
        } else if (item.secondInstallment > 0) {
            return 2
        } else if (item.thirdInstallment > 0) {
            return 3
        } else if (item.fourthInstallment > 0) {
            return 4
        } else if (item.fifthInstallment > 0) {
            return 5
        } else if (item.sixthInstallment > 0) {
            return 6
        }
        return 0
    }
}