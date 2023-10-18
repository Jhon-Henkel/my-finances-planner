import { describe, it, expect } from 'vitest'
import MovementEnum from '../../../resources/js/enums/movementEnum'

describe('Test movementEnum file', () => {
    it('getFilterList', function () {
        const filterList = MovementEnum.getFilterList()
        expect(filterList).toEqual([
            { id: 2, label: 'Este Mês' },
            { id: 3, label: 'Último Mês' },
            { id: 4, label: 'Este Ano' },
        ])
    })

    it('filter.thisMonth', function () {
        expect(MovementEnum.filter.thisMonth()).toEqual(2)
    })

    it('filter.lastMonth', function () {
        expect(MovementEnum.filter.lastMonth()).toEqual(3)
    })

    it('filter.thisYear', function () {
        expect(MovementEnum.filter.thisYear()).toEqual(4)
    })

    it('getTypeList', function () {
        const typeList = MovementEnum.getTypeList()
        expect(typeList).toEqual([
            { id: 0, label: 'Todos' },
            { id: 5, label: 'Despesa' },
            { id: 6, label: 'Receita' },
            { id: 7, label: 'Transferência' }
        ])
    })

    it('getLabelForType', function () {
        expect(MovementEnum.getLabelForType(5)).toEqual('Despesa')
        expect(MovementEnum.getLabelForType(6)).toEqual('Receita')
        expect(MovementEnum.getLabelForType(7)).toEqual('Transferência')
        expect(MovementEnum.getLabelForType(8)).toEqual('Desconhecido')
        expect(MovementEnum.getLabelForType(0)).toEqual('Todos')
    })

    it('type.spent', function () {
        expect(MovementEnum.type.spent()).toEqual(5)
    })

    it('type.gain', function () {
        expect(MovementEnum.type.gain()).toEqual(6)
    })

    it('type.transfer', function () {
        expect(MovementEnum.type.transfer()).toEqual(7)
    })

    it('type.all', function () {
        expect(MovementEnum.type.all()).toEqual(0)
    })
})