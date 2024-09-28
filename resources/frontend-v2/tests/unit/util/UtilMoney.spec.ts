import {describe, it, expect} from "vitest"
import {UtilMoney} from "../../../src/util/UtilMoney"

describe('test UtilMoney const', () => {
    it('should return money ion BR format', () => {
        const value = 1000
        expect(UtilMoney.formatValueToBr(value)).toBe('R$ 1.000,00')
    })

    it('should return money ion BR format with string', () => {
        const value = 0
        expect(UtilMoney.formatValueToBrReturnStringCaseZero(value, 'Sem valor')).toBe('Sem valor')
    })
})
