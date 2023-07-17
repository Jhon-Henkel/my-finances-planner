import { describe, it, expect } from 'vitest'
import IconEnum from '../../../resources/js/enums/iconEnum'

describe('Test iconEnum file', () => {
    it('circleCheck', function () {
        expect(IconEnum.circleCheck()).toStrictEqual(['fas', 'circle-check'])
    })

    it('circleX', function () {
        expect(IconEnum.circleX()).toStrictEqual(['fas', 'circle-xmark'])
    })

    it('circleInfo', function () {
        expect(IconEnum.circleInfo()).toStrictEqual(['fas', 'circle-info'])
    })

    it('circleExclamation', function () {
        expect(IconEnum.circleExclamation()).toStrictEqual(['fas', 'circle-exclamation'])
    })

    it('trashIcon', function () {
        expect(IconEnum.trashIcon()).toStrictEqual(['far', 'trash-can'])
    })

    it('editIcon', function () {
        expect(IconEnum.editIcon()).toStrictEqual(['fas', 'pencil'])
    })

    it('wallet', function () {
        expect(IconEnum.wallet()).toStrictEqual(['fas', 'wallet'])
    })

    it('triangleExclamation', function () {
        expect(IconEnum.triangleExclamation()).toStrictEqual(['fas', 'triangle-exclamation'])
    })

    it('moneyBr', function () {
        expect(IconEnum.moneyBr()).toStrictEqual(['fas', 'brazilian-real-sign'])
    })

    it('check', function () {
        expect(IconEnum.check()).toStrictEqual(['fas', 'check'])
    })

    it('xMark', function () {
        expect(IconEnum.xMark()).toStrictEqual(['fas', 'xmark'])
    })

    it('creditCard', function () {
        expect(IconEnum.creditCard()).toStrictEqual(['fas', 'credit-card'])
    })

    it('user', function () {
        expect(IconEnum.user()).toStrictEqual(['fas', 'user'])
    })

    it('key', function () {
        expect(IconEnum.key()).toStrictEqual(['fas', 'key'])
    })

    it('unlock', function () {
        expect(IconEnum.unlock()).toStrictEqual(['fas', 'unlock'])
    })

    it('invoice', function () {
        expect(IconEnum.invoice()).toStrictEqual(['fas', 'file-invoice-dollar'])
    })

    it('expense', function () {
        expect(IconEnum.expense()).toStrictEqual(['fas', 'money-check-dollar'])
    })

    it('paying', function () {
        expect(IconEnum.paying()).toStrictEqual(['fas', 'hand-holding-dollar'])
    })

    it('back', function () {
        expect(IconEnum.back()).toStrictEqual(['fas', 'angle-left'])
    })

    it('movement', function () {
        expect(IconEnum.movement()).toStrictEqual(['fas', 'money-bill-transfer'])
    })

    it('filterMoney', function () {
        expect(IconEnum.filterMoney()).toStrictEqual(['fas', 'filter-circle-dollar'])
    })

    it('circleArrowUp', function () {
        expect(IconEnum.circleArrowUp()).toStrictEqual(['fas', 'circle-arrow-up'])
    })

    it('circleArrowDown', function () {
        expect(IconEnum.circleArrowDown()).toStrictEqual(['fas', 'circle-arrow-down'])
    })

    it('circleArrowRight', function () {
        expect(IconEnum.circleArrowRight()).toStrictEqual(['fas', 'circle-arrow-right'])
    })

    it('sackDollar', function () {
        expect(IconEnum.sackDollar()).toStrictEqual(['fas', 'sack-dollar'])
    })

    it('wrench', function () {
        expect(IconEnum.wrench()).toStrictEqual(['fas', 'wrench'])
    })

    it('percent', function () {
        expect(IconEnum.percent()).toStrictEqual(['fas', 'percent'])
    })

    it('businessTime', function () {
        expect(IconEnum.businessTime()).toStrictEqual(['fas', 'business-time'])
    })

    it('clock', function () {
        expect(IconEnum.clock()).toStrictEqual(['fas', 'clock'])
    })

    it('info', function () {
        expect(IconEnum.info()).toStrictEqual(['fas', 'info'])
    })

    it('scaleBalanced', function () {
        expect(IconEnum.scaleBalanced()).toStrictEqual(['fas', 'scale-balanced'])
    })

    it('calendarCheck', function () {
        expect(IconEnum.calendarCheck()).toStrictEqual(['fa-solid', 'fa-calendar-check'])
    })

    it('linkOut', function () {
        expect(IconEnum.linkOut()).toStrictEqual(['fas', 'up-right-from-square'])
    })

    it('buildingColumns', function () {
        expect(IconEnum.buildingColumns()).toStrictEqual(['fas', 'building-columns'])
    })
})