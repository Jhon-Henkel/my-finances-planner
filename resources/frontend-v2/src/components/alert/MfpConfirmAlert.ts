import {alertController} from "@ionic/vue"

export class MfpConfirmAlert {
    header: string

    constructor(header: string) {
        this.header = header
    }

    async open(message: string): Promise<boolean> {
        const alert = await alertController.create({
            header: this.header,
            message: message,
            buttons: [{text: 'Não', role: 'cancel'}, {text: 'Sim', role: 'confirm'}]
        })
        await alert.present()
        const event = await alert.onDidDismiss()

        return event.role === 'confirm'
    }
}
