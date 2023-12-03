import MovementEnum from '../enums/movementEnum'
import IconEnum from '../enums/iconEnum'

const iconTools = {
    getIconForMovementType(type) {
        if (type === MovementEnum.type.transfer()) {
            return IconEnum.buildingColumns()
        } else if (type === MovementEnum.type.spent()) {
            return IconEnum.circleArrowDown()
        } else if (type === MovementEnum.type.gain()) {
            return IconEnum.circleArrowUp()
        } else if (type === MovementEnum.type.investmentCDB()) {
            return IconEnum.piggyBank()
        }
    },
    getCssForMovementType(type) {
        if (type === MovementEnum.type.transfer()) {
            return 'movement-transfer-icon'
        } else if (type === MovementEnum.type.spent()) {
            return 'movement-spent-icon'
        } else if (type === MovementEnum.type.gain()) {
            return 'movement-gain-icon'
        } else if (type === MovementEnum.type.investmentCDB()) {
            return 'movement-investment-icon'
        }
    }
}

export default iconTools