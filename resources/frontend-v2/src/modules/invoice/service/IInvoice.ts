export interface IInvoice {
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
}