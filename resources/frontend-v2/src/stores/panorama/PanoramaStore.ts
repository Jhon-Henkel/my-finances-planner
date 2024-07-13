import {defineStore} from "pinia"
import {PanoramaService} from "@/services/panorama/PanoramaService"
import {IPanoramaView} from "@/services/panorama/IPanoramaView"
import {PanoramaModel} from "@/model/panorama/PanoramaModel"

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