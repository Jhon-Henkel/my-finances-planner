import movementEnum from "../enums/movementEnum";

const numberTools = {
    getPercentageNumber: function (value, total) {
        return ((value / total) * 100).toFixed(2) + ' %'
    },
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
    },
    calculateTotalPerMonthInvoiceItem: function (invoiceItem) {
        let firstMonth = 0
        let secondMonth = 0
        let thirdMonth = 0
        let forthMonth = 0
        let fifthMonth = 0
        let sixthMonth = 0
        let totalRemaining = 0
        let total = 0
        invoiceItem.forEach(item => {
            if (item.firstInstallment) {
                firstMonth = firstMonth + item.firstInstallment
                total = total + item.firstInstallment
            }
            if (item.secondInstallment) {
                secondMonth = secondMonth + item.secondInstallment
                total = total + item.secondInstallment
            }
            if (item.thirdInstallment) {
                thirdMonth = thirdMonth + item.thirdInstallment
                total = total + item.thirdInstallment
            }
            if (item.forthInstallment) {
                forthMonth = forthMonth + item.forthInstallment
                total = total + item.forthInstallment
            }
            if (item.fifthInstallment) {
                fifthMonth = fifthMonth + item.fifthInstallment
                total = total + item.fifthInstallment
            }
            if (item.sixthInstallment) {
                sixthMonth = sixthMonth + item.sixthInstallment
                total = total + item.sixthInstallment
            }
            if (item.totalRemainingValue) {
                totalRemaining = totalRemaining + item.totalRemainingValue
            }
        })
        return {
            firstMonth: firstMonth,
            secondMonth: secondMonth,
            thirdMonth: thirdMonth,
            forthMonth: forthMonth,
            fifthMonth: fifthMonth,
            sixthMonth: sixthMonth,
            totalRemaining: totalRemaining,
            total: total
        }
    },
}
export default numberTools