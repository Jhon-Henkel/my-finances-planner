import { describe, it, expect, vitest } from 'vitest'
import calendarTools from "../../../../resources/js/tools/calendarTools"

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

    it('threeHoursInMs', async () => {
        let time = calendarTools.threeHoursInMs()
        expect(time).toBe(10800000)
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

    it('getToday', async () => {
        let date = calendarTools.getToday()
        expect(date).toBeInstanceOf(Date)
        expect(date.getDate()).toBe(new Date().getDate())
    })

    it('getNextSixMonths with months into same year', async () => {
        let months = calendarTools.getNextSixMonths(0)
        expect(months).toBeInstanceOf(Array)
        expect(months.length).toBe(6)
        expect(months[0]).toBe(0)
        expect(months[1]).toBe(1)
        expect(months[2]).toBe(2)
        expect(months[3]).toBe(3)
        expect(months[4]).toBe(4)
        expect(months[5]).toBe(5)
    })

    it('getNextSixMonths with months into two different year', async () => {
        let months = calendarTools.getNextSixMonths(10)
        expect(months).toBeInstanceOf(Array)
        expect(months.length).toBe(6)
        expect(months[0]).toBe(10)
        expect(months[1]).toBe(11)
        expect(months[2]).toBe(0)
        expect(months[3]).toBe(1)
        expect(months[4]).toBe(2)
        expect(months[5]).toBe(3)
    })

    it('getNextSixMonths with months into two different year with string number input', async () => {
        let months = calendarTools.getNextSixMonths('10')
        expect(months).toBeInstanceOf(Array)
        expect(months.length).toBe(6)
        expect(months[0]).toBe(10)
        expect(months[1]).toBe(11)
        expect(months[2]).toBe(0)
        expect(months[3]).toBe(1)
        expect(months[4]).toBe(2)
        expect(months[5]).toBe(3)
    })

    it('getThisMonthPeriod test', async () => {
        vitest.spyOn(calendarTools, 'getToday').mockImplementation(() => {
            return new Date('2023-10-16')
        })

        let period = calendarTools.getThisMonthPeriod()
        expect(period[0].toISOString()).toBe('2023-10-01T03:00:00.000Z')
        expect(period[1].toISOString()).toBe('2023-11-01T02:59:59.999Z')
    })

    it('getLastMonthPeriod test', async () => {
        vitest.spyOn(calendarTools, 'getToday').mockImplementation(() => {
            return new Date('2023-10-16')
        })

        let period = calendarTools.getLastMonthPeriod()
        expect(period[0].toISOString()).toBe('2023-09-01T03:00:00.000Z')
        expect(period[1].toISOString()).toBe('2023-10-01T02:59:59.999Z')
    })

    it('getThisYearPeriod test', async () => {
        vitest.spyOn(calendarTools, 'getToday').mockImplementation(() => {
            return new Date('2023-10-16')
        })

        let period = calendarTools.getThisYearPeriod()
        expect(period[0].toISOString()).toBe('2023-01-01T03:00:00.000Z')
        expect(period[1].toISOString()).toBe('2024-01-01T02:59:59.999Z')
    })

    it('getLastYearPeriod test', async () => {
        vitest.spyOn(calendarTools, 'getToday').mockImplementation(() => {
            return new Date('2023-10-16')
        })

        let period = calendarTools.getLastYearPeriod()
        expect(period[0].toISOString()).toBe('2022-01-01T03:00:00.000Z')
        expect(period[1].toISOString()).toBe('2023-01-01T02:59:59.999Z')
    })
})