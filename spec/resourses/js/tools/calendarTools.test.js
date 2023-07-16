import { describe, it, expect } from 'vitest'
import calendarTools from "../../../../resources/js/tools/calendarTools";

describe('testing calendarTools file', () => {
    it('convertDateDbToBr with time', async () => {
        let date = calendarTools.convertDateDbToBr('2021-01-01 15:55:00', true)
        expect(date).toBe('01/01/2021  15:55:00')
    })

    it('convertDateDbToBr without time', async () => {
        let date = calendarTools.convertDateDbToBr('2021-01-01 15:55:00', false)
        expect(date).toBe('01/01/2021')
    })

    it('fiveSecondsTimeInMs', async () => {
        let time = calendarTools.fiveSecondsTimeInMs()
        expect(time).toBe(5000)
    })

    it('threeSecondsTimeInMs', async () => {
        let time = calendarTools.threeSecondsTimeInMs()
        expect(time).toBe(3000)
    })

    it('fiveHundredMs', async () => {
        let time = calendarTools.fiveHundredMs()
        expect(time).toBe(500)
    })

    it('tenSecondsTimeInMs', async () => {
        let time = calendarTools.tenSecondsTimeInMs()
        expect(time).toBe(10000)
    })

    it('twoHundredMs', async () => {
        let time = calendarTools.twoHundredMs()
        expect(time).toBe(200)
    })

    it('oneHundredMs', async () => {
        let time = calendarTools.oneHundredMs()
        expect(time).toBe(100)
    })

    it('getMonthNameByNumber', async () => {
        let month = calendarTools.getMonthNameByNumber(0)
        expect(month).toBe('Janeiro')

        month = calendarTools.getMonthNameByNumber(1)
        expect(month).toBe('Fevereiro')

        month = calendarTools.getMonthNameByNumber(2)
        expect(month).toBe('Março')

        month = calendarTools.getMonthNameByNumber(3)
        expect(month).toBe('Abril')

        month = calendarTools.getMonthNameByNumber(4)
        expect(month).toBe('Maio')

        month = calendarTools.getMonthNameByNumber(5)
        expect(month).toBe('Junho')

        month = calendarTools.getMonthNameByNumber(6)
        expect(month).toBe('Julho')

        month = calendarTools.getMonthNameByNumber(7)
        expect(month).toBe('Agosto')

        month = calendarTools.getMonthNameByNumber(8)
        expect(month).toBe('Setembro')

        month = calendarTools.getMonthNameByNumber(9)
        expect(month).toBe('Outubro')

        month = calendarTools.getMonthNameByNumber(10)
        expect(month).toBe('Novembro')

        month = calendarTools.getMonthNameByNumber(11)
        expect(month).toBe('Dezembro')

        month = calendarTools.getMonthNameByNumber(12)
        expect(month).toBe('Mês inválido')
    })

    it('getThisMonth', async () => {
        let month = calendarTools.getThisMonth()
        expect(month).toBe(new Date().getMonth())
    })
})