import movementEnum from "../enums/movementEnum";

const numberTools = {
    getSumTotalAmount: function (itens) {
        let sumTotalAmount = 0
        itens.forEach(item => {
            sumTotalAmount = sumTotalAmount + item.amount
        })
        return sumTotalAmount
    },
    getSumAmountPerMovementType: function (movement) {
        let sumSpent = 0;
        let sumGain = 0;
        movement.forEach(item => {
            if (item.type === movementEnum.type.gain()) {
                sumGain = sumGain + item.amount
            } else if (item.type === movementEnum.type.spent()) {
                sumSpent = sumSpent + item.amount
            }
        })
        return { totalSpent: sumSpent, totalGain: sumGain }
    }
}
export default numberTools