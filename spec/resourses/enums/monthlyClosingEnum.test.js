import { describe, it, expect } from 'vitest'
import MonthlyClosingEnum from '../../../resources/js/enums/MonthlyClosingEnum'

describe('Test monthlyClosingEnum file', () => {
    it('getFilterList', function () {
        expect(MonthlyClosingEnum.getFilterList()).toEqual([
            { id: 4, label: 'Este Ano' },
            { id: 5, label: 'Último Ano' },
            { id: 6, label: 'Últimos 5 Anos' },
        ])
    })

    it('filter.thisYear', function () {
        expect(MonthlyClosingEnum.filter.thisYear()).toBe(4)
    })

    it('filter.lastYear', function () {
        expect(MonthlyClosingEnum.filter.lastYear()).toBe(5)
    })

    it('filter.lastFiveYears', function () {
        expect(MonthlyClosingEnum.filter.lastFiveYears()).toBe(6)
    })
})