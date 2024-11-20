import {defineStore} from "pinia"
import {PanoramaService} from "@/modules/panorama/service/PanoramaService"
import {IPanoramaView} from "@/modules/panorama/service/IPanoramaView"
import {PanoramaModel} from "@/modules/panorama/model/PanoramaModel"

interface IPanoramaStoreState {
    panorama: IPanoramaView
    isLoaded: boolean,
    installmentSelected: number
}

export const usePanoramaStore = defineStore({
    id: 'panorama',
    state: (): IPanoramaStoreState => ({
        panorama: new PanoramaModel({futureExpenses: []}),
        isLoaded: false,
        installmentSelected: 0
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
        },
        async load() {
            this.isLoaded = false
            this.panorama = await PanoramaService.index()
            this.isLoaded = true
        }
    }
})
