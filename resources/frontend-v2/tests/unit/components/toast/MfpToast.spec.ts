import {describe, it, expect, vitest} from "vitest"
import {toastController} from '@ionic/vue'
import {checkmarkCircleOutline} from 'ionicons/icons'
import {MfpToast} from "../../../../src/components/toast/MfpToast"

describe('MfpToastV2', () => {
    it('should create a toast with default parameters', async () => {
        const mockToast = {
            present: vitest.fn()
        }
        vitest.spyOn(toastController, 'create').mockResolvedValue(mockToast as any)

        const toast = new MfpToast()
        await toast.open('Hello, World!')

        expect(toastController.create).toHaveBeenCalledWith({
            message: 'Hello, World!',
            duration: 2000,
            position: 'top',
            icon: checkmarkCircleOutline,
            swipeGesture: 'vertical',
        })

        expect(mockToast.present).toHaveBeenCalled()
    })

    it('should create a toast with custom parameters', async () => {
        const mockToast = {
            present: vitest.fn()
        }
        vitest.spyOn(toastController, 'create').mockResolvedValue(mockToast as any)

        const toast = new MfpToast(checkmarkCircleOutline, 'bottom', 3000)
        await toast.open('Hello, World!')

        expect(toastController.create).toHaveBeenCalledWith({
            message: 'Hello, World!',
            duration: 3000,
            position: 'bottom',
            icon: checkmarkCircleOutline,
            swipeGesture: 'vertical',
        })

        expect(mockToast.present).toHaveBeenCalled()
    })

    it('should handle empty message', async () => {
        const mockToast = {
            present: vitest.fn()
        }
        vitest.spyOn(toastController, 'create').mockResolvedValue(mockToast as any)

        const toast = new MfpToast()
        await toast.open('')

        expect(toastController.create).toHaveBeenCalledWith({
            message: '',
            duration: 2000,
            position: 'top',
            icon: checkmarkCircleOutline,
            swipeGesture: 'vertical',
        })

        expect(mockToast.present).toHaveBeenCalled()
    })
})