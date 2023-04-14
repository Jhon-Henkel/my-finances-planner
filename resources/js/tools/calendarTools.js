const FIVE_SECONDS_TIME_IN_MS = 5000;
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
    },
    fiveSecondsTimeInMs() {
        return FIVE_SECONDS_TIME_IN_MS
    }
}
export default calendarTools