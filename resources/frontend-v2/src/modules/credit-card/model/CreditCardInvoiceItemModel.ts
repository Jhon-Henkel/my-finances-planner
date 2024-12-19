export class CreditCardInvoiceItemModel {
    id: any
    name: string
    value: number
    installments: number
    nextInstallment: string
    creditCardId: number

    constructor(data: any) {
        this.id = data.id
        this.name = data.name
        this.value = data.value
        this.installments = data.installments
        this.nextInstallment = data.nextInstallment
        this.creditCardId = data.creditCardId
    }
}
