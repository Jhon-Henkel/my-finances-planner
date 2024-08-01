import {MainSettingsModel} from "@/model/settings/MainSettingsModel"
import {ApiRouter} from "@/api/ApiRouter"

export const MainSettingsService = {
    index: async (): Promise<Array<MainSettingsModel>> => {
        const settings = await ApiRouter.settings.index()
        return settings.map((setting: MainSettingsModel) => new MainSettingsModel(setting))
    },
    update: async (data: Array<MainSettingsModel>): Promise<MainSettingsModel> => {
        const settings = await ApiRouter.settings.update(data)
        return new MainSettingsModel(settings)
    }
}