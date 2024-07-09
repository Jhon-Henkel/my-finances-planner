export const UtilMoney = {
    formatValueToBr: (value: number): string => {
        value = parseFloat(String(value))
        return value.toLocaleString(
            'pt-BR',
            {
                style: 'currency',
                currency: 'BRL'
            }
        )
    }
}