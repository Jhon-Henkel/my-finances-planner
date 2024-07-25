import {InvoiceModel} from "@/model/invoice/invoiceModel"

export const InvoiceService = {
    getNextInstallmentValue: (item: InvoiceModel): number => {
        if (item.firstInstallment > 0) {
            return item.firstInstallment
        } else if (item.secondInstallment > 0) {
            return item.secondInstallment
        } else if (item.thirdInstallment > 0) {
            return item.thirdInstallment
        } else if (item.fourthInstallment > 0) {
            return item.fourthInstallment
        } else if (item.fifthInstallment > 0) {
            return item.fifthInstallment
        } else if (item.sixthInstallment > 0) {
            return item.sixthInstallment
        }
        return 0
    },
    getNumberOfNextInvoice: (item: InvoiceModel): number => {
        if (item.firstInstallment > 0) {
            return 1
        } else if (item.secondInstallment > 0) {
            return 2
        } else if (item.thirdInstallment > 0) {
            return 3
        } else if (item.fourthInstallment > 0) {
            return 4
        } else if (item.fifthInstallment > 0) {
            return 5
        } else if (item.sixthInstallment > 0) {
            return 6
        }
        return 0
    },
    getInvoiceValueByNumber: (installment: number, item: InvoiceModel): number => {
        if (installment == 1) {
            return item.firstInstallment
        } else if (installment == 2) {
            return item.secondInstallment
        } else if (installment == 3) {
            return item.thirdInstallment
        } else if (installment == 4) {
            return item.fourthInstallment
        } else if (installment == 5) {
            return item.fifthInstallment
        } else if (installment == 6) {
            return item.sixthInstallment
        }
        return 0
    }
}