import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import ApiRouter from '~js/router/apiRouter'
import CreditCardExpenseForm from '~vue/view/creditCard/expense/CreditCardExpenseForm.vue'

describe('Testing the expense card form render', () => {
    it('should render form for insert one expense', async () => {
        vitest.spyOn(ApiRouter.cards, 'index').mockImplementation(async () => {
            return []
        })

        const mockRoute = {
            params: {
                id: undefined
            }
        }

        const wrapper = shallowMount(CreditCardExpenseForm, {
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                },
                mocks: {
                    $route: mockRoute
                }
            }
        })

        expect(wrapper.html()).toContain('<mfp-message-stub ')
        expect(wrapper.html()).toContain('time="100"></loading-component-stub>')
        expect(wrapper.html()).toContain('class="title"></mfp-title-stub>')
        expect(wrapper.html()).toContain('class="title"></mfp-title-stub>')
        expect(wrapper.html()).toContain('></divider-stub>')
        expect(wrapper.html()).toContain('type="text" class="form-control" id="description-input" placeholder="" minlength="2" required="">')
        expect(wrapper.html()).toContain('for="description-input">Descrição</label></div>')
        expect(wrapper.html()).toContain('type="number" class="form-control" id="purchase-input" placeholder="" min="1" max="31" maxlength="2" required="">')
        expect(wrapper.html()).toContain('customclassform="mt-2" showtitle="true" title="Valor Parcela" masked="false" precision="2" decimal="," thousands="." suffix="" usefloatinglabels="true" value="0">')
        expect(wrapper.html()).toContain('class="form-check-label" for="fix-expense"> Despesa fixa </label>')
        expect(wrapper.html()).toContain('type="checkbox" role="switch" id="fix-expense"></div>')
        expect(wrapper.html()).toContain('class="form-select" id="expense-credit-card" required="">')
        expect(wrapper.html()).toContain('disabled="" value="0">Selecione um cartão</option>')
        expect(wrapper.html()).toContain('for="expense-credit-card">Cartão de crédito</label></div>')
        expect(wrapper.html()).toContain('</divider-stub>')
        expect(wrapper.html()).toContain('redirectto="/gerenciar-cartoes" buttonsuccesstext="" buttonsuccessicon="fas,check" buttoncanceltext="Voltar" buttoncancelicon="fas,angle-left" showbuttoncancel="true"></bottom-buttons-stub>')
    })
})