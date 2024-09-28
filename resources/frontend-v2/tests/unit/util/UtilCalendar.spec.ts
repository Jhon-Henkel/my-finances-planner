import {describe, it, expect} from "vitest"
import {UtilCalendar} from "../../../src/util/UtilCalendar"

describe('test UtilCalendar const', () => {
    it('should return month names labels', () => {
        const months = [
            { month: 0, label: 'Janeiro' },
            { month: 1, label: 'Fevereiro' },
            { month: 2, label: 'Março' },
            { month: 3, label: 'Abril' },
            { month: 4, label: 'Maio' },
            { month: 5, label: 'Junho' },
            { month: 6, label: 'Julho' },
            { month: 7, label: 'Agosto' },
            { month: 8, label: 'Setembro' },
            { month: 9, label: 'Outubro' },
            { month: 10, label: 'Novembro' },
            { month: 11, label: 'Dezembro' }
        ]
        months.forEach(month => {
            const label = UtilCalendar.getMonthNameByNumber(month.month)
            expect(label).toBe(month.label)
        })
    })
})
