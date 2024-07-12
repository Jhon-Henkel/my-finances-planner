import {describe, it, expect, vitest} from "vitest"
import {alertController} from "@ionic/vue"
import {MfpConfirmAlert} from "../../../../src/components/alert/MfpConfirmAlert"

describe("MfpConfirmAlertV2", () => {
    it("opens with provided message and header", async () => {
        const mockAlert = {
            present: vitest.fn(),
            onDidDismiss: vitest.fn().mockResolvedValue({role: 'confirm'})
        }
        vitest.spyOn(alertController, 'create').mockResolvedValue(mockAlert as any)

        const component = new MfpConfirmAlert('Test Header')
        const result = await component.open('Test Message')

        expect(alertController.create).toHaveBeenCalledWith({
            header: 'Test Header',
            message: 'Test Message',
            buttons: [{text: 'Não', role: 'cancel'}, {text: 'Sim', role: 'confirm'}]
        })
        expect(mockAlert.present).toHaveBeenCalled()
        expect(result).toBe(true)
    })

    it("returns false when dismissed without confirmation", async () => {
        const mockAlert = {
            present: vitest.fn(),
            onDidDismiss: vitest.fn().mockResolvedValue({role: 'cancel'})
        }
        vitest.spyOn(alertController, 'create').mockResolvedValue(mockAlert as any)

        const component = new MfpConfirmAlert('Test Header')
        const result = await component.open('Test Message')

        expect(result).toBe(false)
    })
})