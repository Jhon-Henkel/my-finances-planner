import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {PanoramaModel} from "@/modules/panorama/model/PanoramaModel"
import {IPanoramaView} from "@/modules/panorama/service/IPanoramaView"
import {usePanoramaStore} from "@/modules/panorama/store/PanoramaStore"

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
