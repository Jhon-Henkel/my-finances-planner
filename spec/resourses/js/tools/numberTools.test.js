import { describe, it, expect } from 'vitest'
import numberTools from "../../../../resources/js/tools/numberTools"
import movementEnum from "../../../../resources/js/enums/movementEnum"

describe('testing numberTools file', () => {
    it('getPercentageNumber', async () => {
        let percentage = numberTools.getPercentageNumber(10, 100)
        expect(percentage).toBe('10.00 %')

        percentage = numberTools.getPercentageNumber(10, 200)
        expect(percentage).toBe('5.00 %')

        percentage = numberTools.getPercentageNumber(5.55, 50)
        expect(percentage).toBe('11.10 %')

        percentage = numberTools.getPercentageNumber(5.89, 100)
        expect(percentage).toBe('5.89 %')
    })

    it('getSumTotalAmount', async () => {
        let item = [
            {
                amount: 10.55
            },
            {
                amount: 20
            },
            {
                amount: 30.89
            }
        ]

        let total = numberTools.getSumTotalAmount(item)
        expect(total).toBe(61.44)
    })

    it('getSumTotalAmount with empty array', async () => {
        let total = numberTools.getSumTotalAmount([])
        expect(total).toBe(0)
    })

    it('calculateTotalPerMonthInvoiceItem with empty array', async () => {
        let total = numberTools.calculateTotalPerMonthInvoiceItem([])
        expect(total.firstMonth).toBe(0)
        expect(total.secondMonth).toBe(0)
        expect(total.thirdMonth).toBe(0)
        expect(total.forthMonth).toBe(0)
        expect(total.fifthMonth).toBe(0)
        expect(total.sixthMonth).toBe(0)
        expect(total.totalRemaining).toBe(0)
        expect(total.total).toBe(0)
    })

    it('calculateTotalPerMonthInvoiceItem with all month data', async () => {
        let data = [
            {
                firstInstallment: 10.55,
                secondInstallment: 20.66,
                thirdInstallment: 30.76,
                forthInstallment: 40.12,
                fifthInstallment: 50.45,
                sixthInstallment: 60.64,
                totalRemainingValue: 70.07
            },
            {
                firstInstallment: 10,
                secondInstallment: 20,
                thirdInstallment: 30,
                forthInstallment: 40,
                fifthInstallment: 50,
                sixthInstallment: 60,
                totalRemainingValue: 70
            },
            {
                firstInstallment: 10,
                secondInstallment: 20,
                thirdInstallment: 30,
                forthInstallment: 40,
                fifthInstallment: 50,
                sixthInstallment: 60,
                totalRemainingValue: 70
            }
        ]

        let total = numberTools.calculateTotalPerMonthInvoiceItem(data)
        expect(total.firstMonth).toBe(30.55)
        expect(total.secondMonth).toBe(60.66)
        expect(total.thirdMonth).toBe(90.76)
        expect(total.forthMonth).toBe(120.12)
        expect(total.fifthMonth).toBe(150.45)
        expect(total.sixthMonth).toBe(180.64)
        expect(total.totalRemaining).toBe(210.07)
        expect(total.total).toBe(633.1800000000001)
    })

    it('calculateTotalPerMonthInvoiceItem with some month data', async () => {
        let data = [
            {
                firstInstallment: 0,
                secondInstallment: 20.66,
                thirdInstallment: 30.76,
                forthInstallment: 40.12,
                fifthInstallment: 50.45,
                sixthInstallment: 60.64,
                totalRemainingValue: 70.07
            },
            {
                firstInstallment: 10,
                secondInstallment: 0,
                thirdInstallment: 30,
                forthInstallment: 40,
                fifthInstallment: 50,
                sixthInstallment: 60,
                totalRemainingValue: 70
            },
            {
                firstInstallment: 10,
                secondInstallment: 20,
                thirdInstallment: 0,
                forthInstallment: 40,
                fifthInstallment: 50,
                sixthInstallment: 60,
                totalRemainingValue: 70
            },
            {
                firstInstallment: 10,
                secondInstallment: 20,
                thirdInstallment: 30,
                forthInstallment: 0,
                fifthInstallment: 50,
                sixthInstallment: 60,
                totalRemainingValue: 70
            },
            {
                firstInstallment: 10,
                secondInstallment: 20,
                thirdInstallment: 30,
                forthInstallment: 40,
                fifthInstallment: 0,
                sixthInstallment: 60,
                totalRemainingValue: 70
            },
            {
                firstInstallment: 10,
                secondInstallment: 20,
                thirdInstallment: 30,
                forthInstallment: 40,
                fifthInstallment: 50,
                sixthInstallment: 0,
                totalRemainingValue: 70
            },
        ]

        let total = numberTools.calculateTotalPerMonthInvoiceItem(data)
        expect(total.firstMonth).toBe(50)
        expect(total.secondMonth).toBe(100.66)
        expect(total.thirdMonth).toBe(150.76)
        expect(total.forthMonth).toBe(200.12)
        expect(total.fifthMonth).toBe(250.45)
        expect(total.sixthMonth).toBe(300.64)
        expect(total.totalRemaining).toBe(420.07)
        expect(total.total).toBe(1052.63)
    })

    it('getSumAmountPerMovementType', async () => {
        let data = [
            {
                type: movementEnum.type.gain(),
                amount: 10.55
            },
            {
                type: movementEnum.type.gain(),
                amount: 20
            },
            {
                type: movementEnum.type.spent(),
                amount: 30.89
            },
            {
                type: movementEnum.type.spent(),
                amount: 40.89
            }
        ]

        let total = numberTools.getSumAmountPerMovementType(data)

        expect(total.totalGain).toBe(30.55)
        expect(total.totalSpent).toBe(71.78)
    })

    it('getSumAmountPerMovementType with empty array', async () => {
        let total = numberTools.getSumAmountPerMovementType([])

        expect(total.totalGain).toBe(0)
        expect(total.totalSpent).toBe(0)
    })
})