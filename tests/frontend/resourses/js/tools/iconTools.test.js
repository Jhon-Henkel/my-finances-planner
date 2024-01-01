import { describe, it, expect } from 'vitest'
import IconTools from '~js/tools/iconTools'
import MovementEnum from '~js/enums/movementEnum'
import IconEnum from '~js/enums/iconEnum'

describe('testing iconTools file', () => {
    it('getIconForMovementType', async () => {
        let icon = IconTools.getIconForMovementType(MovementEnum.type.transfer())
        expect(icon).toStrictEqual(IconEnum.buildingColumns())

        icon = IconTools.getIconForMovementType(MovementEnum.type.spent())
        expect(icon).toStrictEqual(IconEnum.circleArrowDown())

        icon = IconTools.getIconForMovementType(MovementEnum.type.gain())
        expect(icon).toStrictEqual(IconEnum.circleArrowUp())

        icon = IconTools.getIconForMovementType(MovementEnum.type.investmentCDB())
        expect(icon).toStrictEqual(IconEnum.piggyBank())
    })

    it('getCssForMovementType', async () => {
        let css = IconTools.getCssForMovementType(MovementEnum.type.transfer())
        expect(css).toBe('movement-transfer-icon')

        css = IconTools.getCssForMovementType(MovementEnum.type.spent())
        expect(css).toBe('movement-spent-icon')

        css = IconTools.getCssForMovementType(MovementEnum.type.gain())
        expect(css).toBe('movement-gain-icon')

        css = IconTools.getCssForMovementType(MovementEnum.type.investmentCDB())
        expect(css).toBe('movement-investment-icon')
    })
})