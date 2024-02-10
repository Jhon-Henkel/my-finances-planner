import {describe, it, expect} from 'vitest'
import {shallowMount} from '@vue/test-utils'
import MfpInvoiceCarouselItem from "~vue-component/carrousel/CarouselItemComponent.vue";

describe('Testing the Invoice Carousel Item', () => {
    it('render component with invoice data', () => {
        const invoice = [
            {
                name: 'Test 1',
                firstInstallment: 10.50
            },
            {
                name: 'Test 2',
                firstInstallment: 1.90
            }
        ]

        const wrapper = shallowMount(MfpInvoiceCarouselItem, {
            propsData: {
                months: [1, 2, 3, 4, 5, 6],
                invoices: invoice,
                installment: 'firstInstallment',
                active: true
            },
            global: {
                stubs: {
                    'font-awesome-icon': true
                },
                directives: {
                    tooltip: true
                }
            }
        })

        expect(wrapper.html()).toContain('<div class="carousel-item active">')
        expect(wrapper.html()).toContain('<div class="row card-body text-center">')
        expect(wrapper.html()).toContain('<div class="col-1"></div>')
        expect(wrapper.html()).toContain('<div class="col-10">')
        expect(wrapper.html()).toContain('<h4 class="card-title"><span>Fevereiro</span></h4>')
        expect(wrapper.html()).toContain('<div class="col-12">')
        expect(wrapper.html()).toContain('<hr class="mfp-card-divider">')
        expect(wrapper.html()).toContain('<div class="resume-content">')
        expect(wrapper.html()).toContain('<div class="col-5 d-flex justify-content-center align-items-center"><span>Test 1</span></div>')
        expect(wrapper.html()).toContain('<div class="col-5 d-flex justify-content-center align-items-center"><span>R$ 10,50</span></div>')
        expect(wrapper.html()).toContain('<div class="col-1 d-flex justify-content-center align-items-center">')
        expect(wrapper.html()).toContain('<div class="dropdown-center"><button class="btn btn-outline-success" type="button" data-bs-toggle="dropdown" aria-expanded="false">')
        expect(wrapper.html()).toContain('<font-awesome-icon-stub icon="fas,ellipsis-vertical"></font-awesome-icon-stub>')
        expect(wrapper.html()).toContain('<li><button class="dropdown-item delete-button">')
        expect(wrapper.html()).toContain('<li><button class="dropdown-item edit-button">')
        expect(wrapper.html()).toContain('<font-awesome-icon-stub icon="fas,pencil"></font-awesome-icon-stub> Editar')
        expect(wrapper.html()).toContain('<font-awesome-icon-stub icon="fas,trash-can"></font-awesome-icon-stub> Apagar')
        expect(wrapper.html()).toContain('<div class="col-5 d-flex justify-content-center align-items-center"><span>Test 2</span></div>')
        expect(wrapper.html()).toContain('<div class="col-5 d-flex justify-content-center align-items-center"><span>R$ 1,90</span></div>')
        expect(wrapper.html()).toContain('<div class="col-6"><span>Total</span></div>')
        expect(wrapper.html()).toContain('<div class="col-6"><span>R$ 12,40</span></div>')
        expect(wrapper.html()).toContain('<div class="col-1"></div>')
    })

    it('events test', async () => {
        const invoice = [
            {
                name: 'Test 1',
                firstInstallment: 10.50
            },
            {
                name: 'Test 2',
                firstInstallment: 1.90
            }
        ]

        const wrapper = shallowMount(MfpInvoiceCarouselItem, {
            propsData: {
                months: [1, 2, 3, 4, 5, 6],
                invoices: invoice,
                installment: 'firstInstallment',
                active: true
            },
            global: {
                stubs: {
                    'font-awesome-icon': true
                },
                directives: {
                    tooltip: true
                }
            }
        })

        await wrapper.find('button.edit-button').trigger('click')
        expect(wrapper.emitted('expense-edit').length).toBe(1)

        await wrapper.find('button.delete-button').trigger('click')
        expect(wrapper.emitted('expense-delete').length).toBe(1)
    })

    it('render component without invoice data values', () => {
        const invoice = [
            {
                name: 'Test 1',
                firstInstallment: 0
            },
            {
                name: 'Test 2',
                firstInstallment: 0
            }
        ]

        const wrapper = shallowMount(MfpInvoiceCarouselItem, {
            propsData: {
                months: [1, 2, 3, 4, 5, 6],
                invoices: invoice,
                installment: 'firstInstallment',
                active: true
            },
            global: {
                stubs: {
                    'font-awesome-icon': true
                },
                directives: {
                    tooltip: true
                }
            }
        })

        expect(wrapper.html()).toContain('<div class="carousel-item active">\n' +
            '  <div class="row card-body text-center">\n' +
            '    <div class="col-1"></div>\n' +
            '    <div class="col-10">\n' +
            '      <h4 class="card-title"><span>Fevereiro</span></h4>\n' +
            '      <div class="col-12">\n' +
            '        <hr class="mfp-card-divider">\n' +
            '      </div>\n' +
            '      <div class="resume-content">\n' +
            '        <div class="row">\n' +
            '          <div class="col-12">\n' +
            '            <div class="row">\n' +
            '              <div class="col-12"><span>Não há despesas para este mês</span></div>\n' +
            '              <div class="col-12">\n' +
            '                <hr class="mfp-card-divider">\n' +
            '              </div>\n' +
            '            </div>\n' +
            '          </div>\n' +
            '        </div>\n' +
            '      </div>\n' +
            '      <!--v-if-->\n' +
            '    </div>\n' +
            '    <div class="col-1"></div>\n' +
            '  </div>\n' +
            '</div>')
    })
})
