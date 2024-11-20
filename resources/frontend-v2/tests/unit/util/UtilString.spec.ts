import {describe, it, expect} from "vitest"
import {UtilString} from "../../../src/modules/@shared/util/UtilString"

describe('test UtilString const', () => {
    it('should return text with ellipsis with limit set', () => {
        const text = 'Lorem ipsum dolor sit amet'
        expect(UtilString.ellipsis(text, 10)).toEqual('Lorem ipsu...')
    })

    it('should return text with ellipsis without limit set', () => {
        const text = 'Lorem ipsum dolor sit amet'
        expect(UtilString.ellipsis(text)).toEqual('Lorem ipsum dolor si...')
    })

    it('should return text with first letter capitalized', () => {
        const text = 'lorem ipsum dolor sit amet'
        expect(UtilString.capitalizeFirstLetter(text)).toEqual('Lorem ipsum dolor sit amet')
    })

    it('should return text with first letters capitalized', () => {
        const text = 'lorem ipsum dolor sit amet'
        expect(UtilString.capitalizeFirstLetters(text)).toEqual('Lorem Ipsum Dolor Sit Amet')
    })
})
