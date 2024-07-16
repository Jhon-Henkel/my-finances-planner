export class CardModel {
    id: any
    name: string
    limit: number
    dueDate: number
    closingDay: number
    isThisMonthInvoicePayed: boolean
    totalValueSpending: number
    nextInvoiceValue: number

    constructor(data: any) {
        this.id = data.id
        this.name = data.name
        this.limit = data.limit
        this.dueDate = data.dueDate
        this.closingDay = data.closingDay
        this.isThisMonthInvoicePayed = data.isThisMonthInvoicePayed
        this.totalValueSpending = data.totalValueSpending
        this.nextInvoiceValue = data.nextInvoiceValue
    }
}