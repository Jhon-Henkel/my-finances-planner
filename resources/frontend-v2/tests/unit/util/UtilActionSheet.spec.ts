import {describe, it, expect} from "vitest"
import {UtilActionSheet} from "../../../src/modules/@shared/util/UtilActionSheet"

describe('test UtilActionSheet const', () => {
    it('should makeButtons only with edit button', () => {
        const buttons = UtilActionSheet.makeButtons(true, false, false)
        expect(buttons).toEqual([{text: 'Editar', data: {action: 'edit'}}])
    })

    it('should makeButtons only with delete button', () => {
        const buttons = UtilActionSheet.makeButtons(false, true, false)
        expect(buttons).toEqual([{text: 'Deletar', role: 'destructive', data: {action: 'delete'}}])
    })

    it('should makeButtons only with cancel button', () => {
        const buttons = UtilActionSheet.makeButtons(false, false, true)
        expect(buttons).toEqual([{text: 'Cancelar', role: 'cancel', data: {action: 'cancel'}}])
    })

    it('should makeButtons with edit and delete button', () => {
        const buttons = UtilActionSheet.makeButtons(true, true, false)
        expect(buttons).toEqual([
            {text: 'Editar', data: {action: 'edit'}},
            {text: 'Deletar', role: 'destructive', data: {action: 'delete'}}
        ])
    })

    it('should makeButtons with edit, delete and cancel button', () => {
        const buttons = UtilActionSheet.makeButtons(true, true, true)
        expect(buttons).toEqual([
            {text: 'Editar', data: {action: 'edit'}},
            {text: 'Deletar', role: 'destructive', data: {action: 'delete'}},
            {text: 'Cancelar', role: 'cancel', data: {action: 'cancel'}}
        ])
    })

    it('should makeButtonsToPanorama', () => {
        const buttons = UtilActionSheet.makeButtonsToPanorama()
        expect(buttons).toEqual([
            { text: 'Pagar', data: { action: 'pay' } },
            { text: 'Adicionar Valor', data: { action: 'add-value' } },
            { text: 'Editar', data: { action: 'edit' } },
            { text: 'Detalhes', data: { action: 'details' } },
            { text: 'Deletar', role: 'destructive', data: { action: 'delete' } },
            { text: 'Cancelar', role: 'cancel', data: { action: 'cancel' } }
        ])
    })

    it('should makeButtonsToFutureProfits', () => {
        const buttons = UtilActionSheet.makeButtonsToFutureProfits()
        expect(buttons).toEqual([
            { text: 'Receber', data: { action: 'receive' } },
            { text: 'Editar', data: { action: 'edit' } },
            { text: 'Detalhes', data: { action: 'details' } },
            { text: 'Deletar', role: 'destructive', data: { action: 'delete' } },
            { text: 'Cancelar', role: 'cancel', data: { action: 'cancel' } }
        ])
    })

    it('should makeButtonsToCards', () => {
        const buttons = UtilActionSheet.makeButtonsToCards()
        expect(buttons).toEqual([
            { text: 'Editar', data: { action: 'edit' } },
            { text: 'Pagar Próxima Fatura', data: { action: 'pay' } },
            { text: 'Adicionar Compra', data: { action: 'new-invoice-item' } },
            { text: 'Ver Faturas', data: { action: 'see-invoices' } },
            { text: 'Detalhes', data: { action: 'details' } },
            { text: 'Deletar', role: 'destructive', data: { action: 'delete' } },
            { text: 'Cancelar', role: 'cancel', data: { action: 'cancel' } }
        ])
    })
})
