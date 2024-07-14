export class FutureProfitsModel {
    id: any
    name: string
    countId: number
    countName: string
    remainingInstallments: number
    nextInstallmentDay: string
    nextInstallmentDate: string
    firstInstallment: number
    secondInstallment: number
    thirdInstallment: number
    fourthInstallment: number
    fifthInstallment: number
    sixthInstallment: number
    totalRemainingValue: number

    constructor(data: any) {
        this.id = data.id
        this.name = data.name
        this.countId = data.countId
        this.countName = data.countName
        this.remainingInstallments = data.remainingInstallments
        this.nextInstallmentDay = data.nextInstallmentDay
        this.nextInstallmentDate = data.nextInstallmentDate
        this.firstInstallment = data.firstInstallment
        this.secondInstallment = data.secondInstallment
        this.thirdInstallment = data.thirdInstallment
        this.fourthInstallment = data.fourthInstallment
        this.fifthInstallment = data.fifthInstallment
        this.sixthInstallment = data.sixthInstallment
        this.totalRemainingValue = data.totalRemainingValue
    }
}