import { describe, it, expect } from 'vitest'
import InvestmentEnum from '~js/enums/investmentEnum'

describe('Test investmentEnum file', () => {
    it('getFilterList', function () {
        expect(InvestmentEnum.getFilterList()).toStrictEqual([
            { id: 1, label: 'CDB' },
            { id: 2, label: 'CDB com Limite de Crédito' }
        ])
    })

    it('type.cdb', function () {
        expect(InvestmentEnum.type.cdb()).toBe(1)
    })

    it('type.cdbCreditLimit', function () {
        expect(InvestmentEnum.type.cdbCreditLimit()).toBe(2)
    })

    it('getLabel', function () {
        expect(InvestmentEnum.getLabel(1)).toBe('CDB')
        expect(InvestmentEnum.getLabel(2)).toBe('CDB com Limite de Crédito')
        expect(InvestmentEnum.getLabel(99999)).toBe('Desconhecido')
    })
})