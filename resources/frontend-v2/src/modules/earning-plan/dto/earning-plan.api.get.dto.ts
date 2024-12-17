export default interface EarningPlanApiGetDto {
    id: number,
    wallet_id: number,
    description: string,
    amount: string,
    installments: number,
    forecast: string
    created_at: string
    updated_at: string
}
