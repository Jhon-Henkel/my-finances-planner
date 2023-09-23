import { describe, it, expect } from 'vitest'
import messageTools from "../../../../resources/js/tools/messageTools"

describe('testing messageTools file', () => {
    it('newMessage', async () => {
        let message = messageTools.newMessage('success', 'message', 'header')
        expect(message.alertType).toBe('success')
        expect(message.alertMessage).toBe('message')
        expect(message.alertHeader).toBe('header')
    })

    it('successMessage', async () => {
        let message = messageTools.successMessage('message')
        expect(message.alertType).toBe('success')
        expect(message.alertMessage).toBe('message')
        expect(message.alertHeader).toBe('Sucesso!')
    })

    it('infoMessage', async () => {
        let message = messageTools.infoMessage('message')
        expect(message.alertType).toBe('info')
        expect(message.alertMessage).toBe('message')
        expect(message.alertHeader).toBe('Informação!')
    })

    it('errorMessage', async () => {
        let message = messageTools.errorMessage('message')
        expect(message.alertType).toBe('warning')
        expect(message.alertMessage).toBe('message')
        expect(message.alertHeader).toBe('Ocorreu um erro!')
    })

    it('warningMessage', async () => {
        let message = messageTools.warningMessage('message')
        expect(message.alertType).toBe('warning')
        expect(message.alertMessage).toBe('message')
        expect(message.alertHeader).toBe('Atenção!')

        message = messageTools.warningMessage('message 2', 'header 2')
        expect(message.alertType).toBe('warning')
        expect(message.alertMessage).toBe('message 2')
        expect(message.alertHeader).toBe('header 2')
    })

    it('invalid fields', async () => {
        let message = messageTools.invalidFieldMessage('testField')
        expect(message.alertType).toBe('info')
        expect(message.alertMessage).toBe('Campo "testField" é inválido!')
        expect(message.alertHeader).toBe('Campo inválido!')
    })
})