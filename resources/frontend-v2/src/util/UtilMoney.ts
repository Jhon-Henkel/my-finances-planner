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
    },
    formatValueToBrReturnHyphenCaseZero: (value: number): string => {
        value = parseFloat(String(value))
        if (value === 0) {
            return '-'
        }
        return UtilMoney.formatValueToBr(value)
    }
}