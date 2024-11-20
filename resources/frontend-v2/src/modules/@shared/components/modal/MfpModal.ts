import {modalController} from "@ionic/vue"
import type {ComponentRef} from '@ionic/core'

export class MfpModal {
    component: ComponentRef
    backdropDismiss: boolean

    constructor(component: ComponentRef, backdropDismiss: boolean = false) {
        this.component = component
        this.backdropDismiss = backdropDismiss
    }

    async open(props: object = {}) {
        const modal = await modalController.create({
            component: this.component,
            componentProps: props,
            initialBreakpoint: 0.90,
            breakpoints: [0.90, 1],
            handleBehavior: 'cycle',
            backdropDismiss: this.backdropDismiss
        })
        await modal.present()
    }
}