import {describe, it, expect, vitest} from "vitest"
import {alertController} from "@ionic/vue"
import {MfpOkAlert} from "../../../../src/components/alert/MfpOkAlert"

describe("MfpOkAlertV2", () => {
    it("opens with provided message and header", async () => {
        const mockAlert = {
            present: vitest.fn()
        }
        vitest.spyOn(alertController, 'create').mockResolvedValue(mockAlert as any)

        const component = new MfpOkAlert('Test Header')
        await component.open('Test Message')

        expect(alertController.create).toHaveBeenCalledWith({
            header: 'Test Header',
            message: 'Test Message',
            buttons: ['Ok']
        })
        expect(mockAlert.present).toHaveBeenCalled()
    })
})