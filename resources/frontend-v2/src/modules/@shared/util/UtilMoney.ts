export const UtilMoney = {
    formatValueToBr: (value: number|string): string => {
        value = parseFloat(String(value))
        return value.toLocaleString(
            'pt-BR',
            {
                style: 'currency',
                currency: 'BRL'
            }
        )
    },
    formatValueToBrReturnStringCaseZero: (value: number|string, string: string = ''): string => {
        value = parseFloat(String(value))
        if (value === 0) {
            return string
        }
        return UtilMoney.formatValueToBr(value)
    }
}
