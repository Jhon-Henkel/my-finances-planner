import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import WalletForm from '~vue/view/wallet/WalletFormView.vue'

describe('Testing the form from wallet render', () => {
    it('should render form to insert new wallet', async () => {
        const mockRoute = {
            params: {
                id: undefined
            }
        }

        const wrapper = shallowMount(WalletForm, {
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                },
                directives: {
                    tooltip: true
                },
                mocks: {
                    $route: mockRoute
                }
            }
        })

        expect(wrapper.html()).toContain('</mfp-message-stub>')
        expect(wrapper.html()).toContain('time="100"></loading-component-stub>')
        expect(wrapper.html()).toContain('class="title"></mfp-title-stub>')
        expect(wrapper.html()).toContain('class="was-validated form-floating text-black">')
        expect(wrapper.html()).toContain('class="row justify-content-center">')
        expect(wrapper.html()).toContain('type="text" class="form-control" id="wallet-name-input" placeholder="" minlength="2" required="">')
        expect(wrapper.html()).toContain('for="wallet-name-input">Nome</label></div>')
        expect(wrapper.html()).toContain('customclasscol="col-4" customclassrow="justify-content-center" customclassform="mt-2" showtitle="true" title="Valor" masked="false" precision="2" decimal="," thousands="." suffix="" usefloatinglabels="true" value="0"></input-money-stub>')
        expect(wrapper.html()).toContain('class="form-select" id="expense-credit-card" required="">')
        expect(wrapper.html()).toContain('disabled="" value="0">Selecione um tipo de conta</option>')
        expect(wrapper.html()).toContain('value="5">Dinheiro</option>')
        expect(wrapper.html()).toContain('value="6">Conta Bancária</option>')
        expect(wrapper.html()).toContain('value="8">Vale Alimentação</option>')
        expect(wrapper.html()).toContain('value="9">Vale Transporte</option>')
        expect(wrapper.html()).toContain('value="10">Vale Saúde</option>')
        expect(wrapper.html()).toContain('value="0">Outros</option>')
        expect(wrapper.html()).toContain('for="expense-credit-card">Cartão de crédito</label></div>')
        expect(wrapper.html()).toContain('redirectto="/carteiras" buttonsuccesstext="" buttonsuccessicon="fas,check" buttoncanceltext="Voltar" buttoncancelicon="fas,angle-left" showbuttoncancel="true"></bottom-buttons-stub>')
    })
})