import { describe, it, expect } from 'vitest'
import MessageEnum from '../../../resources/js/enums/messageEnum'

describe('Test messageEnum file', () => {
    it('alertTypeSuccess', function () {
        expect(MessageEnum.alertTypeSuccess()).toBe('success')
    })

    it('alertTypeError', function () {
        expect(MessageEnum.alertTypeError()).toBe('error')
    })

    it('alertTypeInfo', function () {
        expect(MessageEnum.alertTypeInfo()).toBe('info')
    })

    it('alertTypeWarning', function () {
        expect(MessageEnum.alertTypeWarning()).toBe('warning')
    })
})