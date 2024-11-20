import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {PanoramaModel} from "@/model/panorama/PanoramaModel"
import {IPanoramaView} from "@/services/panorama/IPanoramaView"
import {usePanoramaStore} from "@/stores/panorama/PanoramaStore"

export const PanoramaService = {
    index: async (): Promise<IPanoramaView> => {
        const data = await ApiRouter.panorama.index()
        return new PanoramaModel(data)
    },
    forceReloadStore: async () => {
        const store = usePanoramaStore()
        store.loadAgainOnNextTick()
        await store.load()
    }
}
