export const UtilString = {
    ellipsis: (string: string, maxLength: number = 20) => {
        if (string.length > maxLength) {
            return string.slice(0, maxLength) + '...'
        }
        return string
    }
}