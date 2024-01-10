import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import ApiRouter from "~js/router/apiRouter";
import CalendarTools from "~js/tools/calendarTools";
import PanoramaView from "~vue/view/panorama/PanoramaView.vue";

describe('Testing the panorama basic render', () => {
    it('should render panorama basic screen view', async () => {
        vitest.spyOn(ApiRouter.panorama, 'index').mockImplementation(async () => {
            return {
                futureExpenses: [{
                    countId: 7,
                    countName: "Vale Alimentação",
                    fifthInstallment: 1,
                    firstInstallment: 0,
                    fourthInstallment: 1,
                    id: 10,
                    name: "teste",
                    nextInstallmentDay: "16",
                    remainingInstallments: 9,
                    secondInstallment: 1,
                    sixthInstallment: 1,
                    thirdInstallment: 1,
                    totalRemainingValue: 9
                }],
                totalCreditCardExpenses: {
                    countId: 0,
                    countName: null,
                    fifthInstallment: 322.35,
                    firstInstallment: 405.69,
                    fourthInstallment: 405.69,
                    id: 0,
                    name: "SumPerMonthOfInvoices",
                    nextInstallmentDay: "25",
                    remainingInstallments: 0,
                    secondInstallment: 405.69,
                    sixthInstallment: 266.48,
                    thirdInstallment: 405.69,
                    totalRemainingValue: 0
                },
                totalFutureExpenses: {
                    countId: 0,
                    countName: null,
                    fifthInstallment: 1501,
                    firstInstallment: 1499,
                    fourthInstallment: 1501,
                    id: 0,
                    name: "SumPerMonthOfInvoices",
                    nextInstallmentDay: "22",
                    remainingInstallments: 0,
                    secondInstallment: 1501,
                    sixthInstallment: 1501,
                    thirdInstallment: 1501,
                    totalRemainingValue: 0
                },
                totalFutureGains: {
                    countId: 0,
                    countName: null,
                    fifthInstallment: 0,
                    firstInstallment: 10,
                    fourthInstallment: 0,
                    id: 0,
                    name: "SumPerMonthOfInvoices",
                    nextInstallmentDay: "1",
                    remainingInstallments: 0,
                    secondInstallment: 0,
                    sixthInstallment: 0,
                    thirdInstallment: 0,
                    totalRemainingValue: 0
                },
                totalLeft: {
                    countId: 0,
                    countName: null,
                    fifthInstallment: -1823.35,
                    firstInstallment: -1894.69,
                    fourthInstallment: -1906.69,
                    id: 0,
                    name: "SumTotalLeft",
                    nextInstallmentDay: "12",
                    remainingInstallments: 0,
                    secondInstallment: -1906.69,
                    sixthInstallment: -1767.48,
                    thirdInstallment: -1906.69,
                    totalRemainingValue: 0
                },
                totalWalletValue: 40051.29
            }
        })
        vitest.spyOn(CalendarTools, 'getThisMonth').mockImplementation(() => {
            return 1
        })
        vitest.spyOn(CalendarTools, 'getNextSixMonths').mockImplementation(() => {
            return [1, 2, 3, 4, 5, 6]
        })
        const wrapper = shallowMount(PanoramaView, {
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                },
                directives: {
                    tooltip: true
                },
            }
        })
        expect(wrapper.html()).toContain('class="base-container">')
        expect(wrapper.html()).toContain('</mfp-message')
        expect(wrapper.html()).toContain('</loading-component')
        expect(wrapper.html()).toContain('class="nav mt-2 justify-content-end">')
        expect(wrapper.html()).toContain('title="Panorama"></mfp-title')
        expect(wrapper.html()).toContain('class="btn btn-success rounded-2 top-button">')
        expect(wrapper.html()).toContain('icon="fas,hand-holding-dollar" class="me-2"></font-awesome')
        expect(wrapper.html()).toContain('> Novo Gasto Futuro')
        expect(wrapper.html()).toContain('</divider')
        expect(wrapper.html()).toContain('class="card glass success balance-card">')
        expect(wrapper.html()).toContain('class="card-body text-center">')
        expect(wrapper.html()).toContain('class="card-text">')
        expect(wrapper.html()).toContain('class="table-responsive-lg">')
        expect(wrapper.html()).toContain('class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">')
        expect(wrapper.html()).toContain('class="text-center">')
        expect(wrapper.html()).toContain('colspan="11">Despesas</td>')
        expect(wrapper.html()).toContain('class="text-center border-table">')
        expect(wrapper.html()).toContain('icon="fa-solid,fa-calendar-check">')
        expect(wrapper.html()).toContain('>Descrição</th>')
        expect(wrapper.html()).toContain('>Restam</th>')
        expect(wrapper.html()).toContain('>Ações</th>')
        expect(wrapper.html()).toContain('</thead>')
        expect(wrapper.html()).toContain('class="text-center table-body-hover">')
        expect(wrapper.html()).toContain('colspan="11">Nenhuma despesa cadastrada ainda!</td>')
        expect(wrapper.html()).toContain('class="text-center border-table-top">')
        expect(wrapper.html()).toContain('colspan="10" class="no-hover"><a')
        expect(wrapper.html()).toContain('class="a-default"> Gerenciar Registros </a></td>')
        expect(wrapper.html()).toContain('showpayreceive="false" checktooltip="Pagar Despesa" walletid="0" partiallabel="Pagamento parcial" validatewalletvalue="true" value="0">')
        expect(wrapper.html()).toContain('class="card glass success balance-card">')
        expect(wrapper.html()).toContain('class="card-body text-center">')
        expect(wrapper.html()).toContain('class="card-title">')
        expect(wrapper.html()).toContain('icon="fas,money-bill-transfer" class="me-2"></font-awesome')
        expect(wrapper.html()).toContain('class="table table-transparent table-borderless">')
        expect(wrapper.html()).toContain('class="text-center text-nowrap">')
        expect(wrapper.html()).toContain('icon="fas,circle-arrow-down" class="spent-icon me-2"></font-awesome')
        expect(wrapper.html()).toContain('class="text-start">Gastos</td>')
        expect(wrapper.html()).toContain('>-</td>')
        expect(wrapper.html()).toContain('icon="fas,credit-card" class="card-icon me-2"></font-awesome')
        expect(wrapper.html()).toContain('class="text-start"> Cartões <a')
        expect(wrapper.html()).toContain('href="/gerenciar-cartoes" class="a-default" target="_blank">')
        expect(wrapper.html()).toContain('icon="fas,up-right-from-square" class="icon-out"></font-awesome')
        expect(wrapper.html()).toContain('icon="fas,circle-arrow-up" class="gain-icon me-2"></font-awesome')
        expect(wrapper.html()).toContain('class="text-start"> Ganhos <a')
        expect(wrapper.html()).toContain('href="/ganhos-futuros" class="a-default" target="_blank">')
        expect(wrapper.html()).toContain('icon="fas,up-right-from-square" class="icon-out"></font-awesome')
        expect(wrapper.html()).toContain('icon="fas,wallet" class="movement-gain-icon me-2"></font-awesome')
        expect(wrapper.html()).toContain('class="text-start"> Carteira <a')
        expect(wrapper.html()).toContain('href="/carteiras" class="a-default" target="_blank">')
        expect(wrapper.html()).toContain('icon="fas,up-right-from-square" class="icon-out"></font-awesome')
        expect(wrapper.html()).toContain('icon="fas,circle-arrow-right" class="remaining-icon me-2"></font-awesome')
        expect(wrapper.html()).toContain('class="text-start">Sobras</td>')
        expect(wrapper.html()).toContain('</divider')
    })
})
