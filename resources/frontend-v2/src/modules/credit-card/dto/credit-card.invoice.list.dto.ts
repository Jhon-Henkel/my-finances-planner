export default interface ICreditCardInvoiceListDto {
    id: number
    credit_card_id: number
    description: string
    amount: number
    installments: number
    forecast: string
    created_at: string
    updated_at: string
}
