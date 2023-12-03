import { endOfMonth, endOfYear, startOfMonth, startOfYear, subMonths, subYears } from 'date-fns'

const SIX_HOURS_IN_MS = 21600000
const THREE_HOURS_IN_MS = 10800000
const TEN_SECONDS_TIME_IN_MS = 10000
const FIVE_SECONDS_TIME_IN_MS = 5000
const THREE_SECONDS_TIME_IN_MS = 3000
const FIVE_HUNDRED_MS = 500
const TWO_HUNDRED_MS = 200
const ONE_HUNDRED_MS = 100

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
                second: 'numeric'
            }
        }
        const dateBr = new Date(date).toLocaleDateString('pt-br', option).toString()
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
    tenSecondsTimeInMs() {
        return TEN_SECONDS_TIME_IN_MS
    },
    twoHundredMs() {
        return TWO_HUNDRED_MS
    },
    oneHundredMs() {
        return ONE_HUNDRED_MS
    },
    threeHoursInMs() {
        return THREE_HOURS_IN_MS
    },
    sixHoursInMs() {
        return SIX_HOURS_IN_MS
    },
    getNextThreeMonthsWithYear() {
        const months = []
        const date = this.getToday()
        let month = date.getMonth()
        let year = date.getFullYear()
        for (let index = 0; index < 3; index++) {
            if (month > 11) {
                month = 0
                year++
            }
            months.push({ month, year })
            month++
        }
        return months
    },
    getMonthNameByNumber(month) {
        switch (month) {
        case 0:
            return 'Janeiro'
        case 1:
            return 'Fevereiro'
        case 2:
            return 'Março'
        case 3:
            return 'Abril'
        case 4:
            return 'Maio'
        case 5:
            return 'Junho'
        case 6:
            return 'Julho'
        case 7:
            return 'Agosto'
        case 8:
            return 'Setembro'
        case 9:
            return 'Outubro'
        case 10:
            return 'Novembro'
        case 11:
            return 'Dezembro'
        default:
            return 'Mês inválido'
        }
    },
    getThisMonth() {
        const date = new Date()
        return date.getMonth()
    },
    getToday() {
        return new Date()
    },
    addDaysInDate(date, days) {
        date.setDate(date.getDate() + days)
        const explodeDate = date.toLocaleDateString('en-US').split('/')
        let day = explodeDate[1]
        let month = explodeDate[0]
        if (day.length === 1) {
            day = '0' + day
        }
        if (month.length === 1) {
            month = '0' + month
        }
        return explodeDate[2] + '-' + month + '-' + day
    },
    getNextSixMonths(thisMonth) {
        const months = []
        let month = parseInt(thisMonth)
        for (let index = 0; index < 6; index++) {
            if (month > 11) {
                month = 0
            }
            months.push(month)
            month++
        }
        return months
    },
    getThisMonthPeriod() {
        const date = this.getToday()
        return [
            startOfMonth(date).toLocaleDateString('sv-SE').split('T')[0],
            endOfMonth(date).toLocaleDateString('sv-SE').split('T')[0]
        ]
    },
    getLastMonthPeriod() {
        const date = this.getToday()
        return [
            startOfMonth(subMonths(date, 1)).toLocaleDateString('sv-SE').split('T')[0],
            endOfMonth(subMonths(date, 1)).toLocaleDateString('sv-SE').split('T')[0]
        ]
    },
    getThisYearPeriod() {
        const date = this.getToday()
        return [
            startOfYear(date).toLocaleDateString('sv-SE').split('T')[0],
            endOfYear(date).toLocaleDateString('sv-SE').split('T')[0]
        ]
    },
    getLastYearPeriod() {
        const date = this.getToday()
        return [
            startOfYear(subYears(date, 1)).toLocaleDateString('sv-SE').split('T')[0],
            endOfYear(subYears(date, 1)).toLocaleDateString('sv-SE').split('T')[0]
        ]
    },
    getLastOneYearPeriod() {
        const date = this.getToday()
        return [
            subYears(date, 1).toLocaleDateString('sv-SE').split('T')[0],
            date.toLocaleDateString('sv-SE').split('T')[0]
        ]
    }
}
export default calendarTools