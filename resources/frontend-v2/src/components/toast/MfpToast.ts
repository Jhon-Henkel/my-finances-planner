import {toastController} from "@ionic/vue"
import {checkmarkCircleOutline} from "ionicons/icons"

export class MfpToast {
    icon: string
    position?: 'top' | 'bottom' | 'middle'
    duration: number

    constructor(icon: string = checkmarkCircleOutline, position: 'top' | 'bottom' | 'middle' = 'top', duration: number = 2000) {
        this.icon = icon
        this.position = position
        this.duration = duration
    }

    async open(message: string) {
        const toast = await toastController.create({
            message: message,
            duration: this.duration,
            position: this.position,
            icon: this.icon,
            swipeGesture: 'vertical',
        })
        await toast.present()
    }
}