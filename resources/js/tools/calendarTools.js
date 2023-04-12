const calendarTools = {
    convertDateToBr(date, withTime) {
        let option = {}
        if (withTime) {
            option = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
            }
        }
        let dateBr = new Date(date).toLocaleDateString('pt-br', option).toString()
        return dateBr.replace(',', ' ')
    }
}
export default calendarTools