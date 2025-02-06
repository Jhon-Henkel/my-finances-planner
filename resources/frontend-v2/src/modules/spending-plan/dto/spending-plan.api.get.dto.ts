export default interface SpendingPlanApiGetDto {
    id: number
    wallet_id: number
    description: string
    amount: number
    installments: number
    forecast: string
    created_at: string
    updated_at: string
    bank_slip_code: string|null
}
