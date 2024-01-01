import { describe, it, expect } from 'vitest'
import WalletEnum from '~js/enums/walletEnum'

describe('Test walletEnum file', () => {
    it('getDescription', function () {
        expect(WalletEnum.getDescription(0)).toEqual('Outros')
        expect(WalletEnum.getDescription(5)).toEqual('Dinheiro')
        expect(WalletEnum.getDescription(6)).toEqual('Conta Bancária')
        expect(WalletEnum.getDescription(8)).toEqual('Vale Alimentação')
        expect(WalletEnum.getDescription(9)).toEqual('Vale Transporte')
        expect(WalletEnum.getDescription(10)).toEqual('Vale Saúde')
        expect(WalletEnum.getDescription(14)).toEqual('Desconhecido')
    })

    it('getIdAndDescriptionTypeList', function () {
        const list = WalletEnum.getIdAndDescriptionTypeList()
        expect(list).toEqual([
            {
                id: 5,
                description: 'Dinheiro'
            },
            {
                id: 6,
                description: 'Conta Bancária'
            },
            {
                id: 8,
                description: 'Vale Alimentação'
            },
            {
                id: 9,
                description: 'Vale Transporte'
            },
            {
                id: 10,
                description: 'Vale Saúde'
            },
            {
                id: 0,
                description: 'Outros'
            }
        ])
    })

    it('type.moneyType', function () {
        expect(WalletEnum.type.moneyType).toEqual(5)
    })

    it('type.bankType', function () {
        expect(WalletEnum.type.bankType).toEqual(6)
    })

    it('type.mealTicketType', function () {
        expect(WalletEnum.type.mealTicketType).toEqual(8)
    })

    it('type.transportTicketType', function () {
        expect(WalletEnum.type.transportTicketType).toEqual(9)
    })

    it('type.healthTicketType', function () {
        expect(WalletEnum.type.healthTicketType).toEqual(10)
    })

    it('type.otherType', function () {
        expect(WalletEnum.type.otherType).toEqual(0)
    })
})