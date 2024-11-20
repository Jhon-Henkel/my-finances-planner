import {alertController} from "@ionic/vue"

export class MfpOkAlert {
    header: string

    constructor(header: string) {
        this.header = header
    }

    async open(message: string) {
        const alert = await alertController.create({
            header: this.header,
            message: message,
            buttons: ['Ok'],
        })
        await alert.present()
    }
}
