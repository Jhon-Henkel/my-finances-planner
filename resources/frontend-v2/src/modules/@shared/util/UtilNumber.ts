export const UtilNumber = {
    addZeroBeforeNumberIfMinorOfTen: (number: number|string): string => {
        number = parseInt(String(number))
        if (number < 10) {
            return `0${number}`
        }
        return String(number)
    }
}
