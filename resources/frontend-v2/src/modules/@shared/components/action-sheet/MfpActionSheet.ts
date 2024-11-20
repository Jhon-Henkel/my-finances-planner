import {actionSheetController} from "@ionic/vue"

export class MfpActionSheet {
    buttons: Array<object>

    constructor(buttons: Array<object>) {
        this.buttons = buttons
    }

    async open(): Promise<string | null> {
        const actionSheet = await actionSheetController.create({buttons: this.buttons})
        await actionSheet.present()
        const event = await actionSheet.onDidDismiss()

        return event.data?.action || null
    }
}