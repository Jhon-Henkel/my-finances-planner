const FIVE_SECONDS_TIME_IN_MS = 5000;
const THREE_SECONDS_TIME_IN_MS = 3000;
const FIVE_HUNDRED_MS = 500;
const TWO_HUNDRED_MS = 200;
const ONE_HUNDRED_MS = 100;

const calendarTools = {
    convertDateDbToBr(date, withTime) {
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
    },
    threeSecondsTimeInMs() {
        return THREE_SECONDS_TIME_IN_MS
    },
    fiveHundredMs() {
        return FIVE_HUNDRED_MS
    },
    twoHundredMs() {
        return TWO_HUNDRED_MS
    },
    oneHundredMs() {
        return ONE_HUNDRED_MS
    }
}
export default calendarTools