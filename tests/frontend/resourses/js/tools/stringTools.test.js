import { describe, it, expect } from 'vitest'
import stringTools from "~js/tools/stringTools"

describe('testing stringTools file', () => {
    it('formatFloatValueToBrString', async () => {
        let value = stringTools.formatFloatValueToBrString(10)
        expect(value).toBe('R$ 10,00')

        value = stringTools.formatFloatValueToBrString(10.55)
        expect(value).toBe('R$ 10,55')

        value = stringTools.formatFloatValueToBrString(10.555)
        expect(value).toBe('R$ 10,56')

        value = stringTools.formatFloatValueToBrString(10.554)
        expect(value).toBe('R$ 10,55')

        value = stringTools.formatFloatValueToBrString(null)
        expect(value).toBe('-')
    })
})