interface IItem {
    name: string
    value: number
}

export class FinancialHealthModel {
    expenseItens: Array<IItem> = []
    incomeItens: Array<IItem> = []
    incomeTotalAmount: number = 0
    expenseTotalAmount: number = 0
}