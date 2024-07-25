export const UtilString = {
    ellipsis: (string: string, maxLength: number = 20) => {
        if (!string) return ''
        if (string.length > maxLength) {
            return string.slice(0, maxLength) + '...'
        }
        return string
    },
    capitalizeFirstLetter: function (string: string): string {
        return string.charAt(0).toUpperCase() + string.slice(1)
    },
    capitalizeFirstLetters: function (string: string): string {
        return string.split(' ').map(word => {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        }).join(' ')
    }
}