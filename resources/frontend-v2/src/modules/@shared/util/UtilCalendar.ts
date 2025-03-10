import {endOfMonth, startOfMonth, subDays} from 'date-fns'

export const UtilCalendar = {
    getToday: function(): Date {
        const now: Date =  new Date()
        const saoPauloTime = now.toLocaleString("en-US", {timeZone: "America/Sao_Paulo"})
        return new Date(saoPauloTime)
    },
    makeDate: function(date: string): Date {
        const now: Date =  new Date(date)
        const saoPauloTime = now.toLocaleString("en-US", {timeZone: "America/Sao_Paulo"})
        return new Date(saoPauloTime)
    },
    formatStringToBr: function(date: string): string {
        const dateTime: Date = new Date(date)
        return dateTime.toLocaleDateString('pt-BR', { year: '2-digit', month: '2-digit', day: '2-digit' })
    },
    formatStringToBrOnlyDayAndMonth: function(date: string): string {
        const dateTime: Date = new Date(date)
        return dateTime.toLocaleDateString('pt-BR', { year: undefined, month: '2-digit', day: '2-digit' })
    },
    getTodayIso: function(): string {
        return this.getToday().toISOString()
    },
    toIso: function(date: string): string {
        return this.makeDate(date).toISOString()
    },
    makeStringFilterDate: function(date: string): string {
        const  dateObj: Date = new Date(date)
        const  dateStart: Date = startOfMonth(dateObj)
        const dateEnd: Date = endOfMonth(dateObj)
        const dateStartString: string = new Date(dateStart).toISOString().slice(0, 10)
        const dateEndString: string = new Date(subDays(dateEnd, 1)).toISOString().slice(0, 10)

        return `dateStart=${dateStartString}&dateEnd=${dateEndString}`
    },
    getCurrentMonth(): number {
        const date: Date = this.getToday()
        return date.getMonth()
    },
    getMonthNameByNumber(month: number): string {
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
}
