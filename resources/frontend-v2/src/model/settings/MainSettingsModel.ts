export class MainSettingsModel {
    name: string
    value: string

    constructor(data: any) {
        this.name = data.name
        this.value = String(data.value)
    }
}