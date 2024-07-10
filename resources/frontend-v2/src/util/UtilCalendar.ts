import {endOfMonth, startOfMonth, subDays, format, addDays} from 'date-fns'
import { ptBR } from 'date-fns/locale'
import {UtilString} from "@/util/UtilString"

export const UtilCalendar = {
    getToday: function(): Date {
        const now: Date =  new Date()
        const saoPauloTime = now.toLocaleString("en-US", {timeZone: "America/Sao_Paulo"})
        return new Date(saoPauloTime)
    },
    getTodayIso: function(): string {
        return this.getToday().toISOString()
    },
    formatStringToBr: function(date: string): string {
        const dateTime: Date = new Date(date)
        return dateTime.toLocaleDateString('pt-BR', { year: '2-digit', month: '2-digit', day: '2-digit' })
    },
    makeStringFilterDate: function(date: string): string {
        const  dateObj: Date = new Date(date)
        const  dateStart: Date = startOfMonth(dateObj)
        const dateEnd: Date = endOfMonth(dateObj)
        const dateStartString: string = new Date(dateStart).toISOString().slice(0, 10)
        const dateEndString: string = new Date(subDays(dateEnd, 1)).toISOString().slice(0, 10)

        return `dateStart=${dateStartString}&dateEnd=${dateEndString}`
    },
    makeLabelFilterDate: function(quest: string|null = null): string {
        if (quest === null) {
            const today: Date = this.getToday()
            const string: string = format(today, 'MMMM - yyyy', { locale: ptBR })
            return UtilString.capitalizeFirstLetter(string)
        }
        const slice: string = quest.slice(18, 28)
        const date: Date = new Date(slice)
        const string: string = format(addDays(date, 1), 'MMMM - yyyy', { locale: ptBR })
        return UtilString.capitalizeFirstLetter(string)
    }
}