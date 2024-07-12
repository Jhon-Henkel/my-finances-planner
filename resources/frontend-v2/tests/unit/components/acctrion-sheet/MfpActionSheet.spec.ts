import {describe, it, expect, vitest} from "vitest"
import {actionSheetController} from "@ionic/vue"
import {MfpActionSheet} from "../../../../src/components/action-sheet/MfpActionSheet"

describe("MfpActionSheet", () => {
    it("opens with provided buttons", async () => {
        const mockButtons = [{text: 'Button 1'}, {text: 'Button 2'}, {text: 'Cancel'}]
        const mockActionSheet = {
            present: vitest.fn(),
            onDidDismiss: vitest.fn().mockResolvedValue({data: {action: 'Button 1'}})
        }
        vitest.spyOn(actionSheetController, 'create').mockResolvedValue(mockActionSheet as any)

        const component = new MfpActionSheet(mockButtons)
        const result = await component.open()

        expect(actionSheetController.create).toHaveBeenCalledWith({buttons: mockButtons})
        expect(mockActionSheet.present).toHaveBeenCalled()
        expect(result).toBe('Button 1')
    })

    it("returns null when dismissed without action", async () => {
        const mockButtons = [{text: 'Button 1'}, {text: 'Button 2'}, {text: 'Cancel'}]
        const mockActionSheet = {
            present: vitest.fn(),
            onDidDismiss: vitest.fn().mockResolvedValue({data: {}})
        }
        vitest.spyOn(actionSheetController, 'create').mockResolvedValue(mockActionSheet as any)

        const component = new MfpActionSheet(mockButtons)
        const result = await component.open()

        expect(result).toBeNull()
    })
})