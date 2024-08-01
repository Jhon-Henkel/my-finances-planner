import {MainSettingsModel} from "@/model/settings/MainSettingsModel"
import {MainSettingsService} from "@/services/Settings/MainSettingsService"
import {defineStore} from "pinia"

interface IMainSettingsStore {
    isLoaded: boolean
    settings: Array<MainSettingsModel>
}

export const useMainSettingsStore = defineStore({
    id: 'main-settings',
    state: (): IMainSettingsStore => ({
        isLoaded: false,
        settings: []
    }),
    actions: {
        async load() {
            this.isLoaded = false
            this.settings = await MainSettingsService.index()
            this.isLoaded = true
        },
        getSettingByName(name: string): MainSettingsModel | undefined {
            return this.settings.find(setting => setting.name === name)
        }
    }
})