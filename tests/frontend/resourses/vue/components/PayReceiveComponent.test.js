import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import PayReceiveComponent from '~vue-component/PayReceiveComponent.vue'
import ApiRouter from "~js/router/apiRouter";

describe('Testing the PayReceiveComponent', () => {
    it('should render button with all options', async() => {
        vitest.spyOn(ApiRouter.wallet, 'index').mockImplementation(async() => {
            return [
                {
                    amount: 34.48,
                    createdAt: "2023-12-31 22:21:57",
                    id: 7,
                    name: "Vale Alimentação",
                    type: 8,
                    updatedAt: "2024-01-09 23:37:25"
                },
                {
                    amount: 100.86,
                    createdAt: "2023-12-31 22:21:57",
                    id: 6,
                    name: "Banco Nubank",
                    type: 6,
                    updatedAt: "2023-12-31 22:21:57"
                }
            ]
        })
        const wrapper = shallowMount(PayReceiveComponent, {
            propsData: {
                value: 100.50,
                showPayReceive: true,
                checkTooltip: 'checkTooltip active by vitest',
                walletId: 1,
                partialLabel: 'partialLabel active by vitest',
                validateWalletValue: true
            },
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
        expect(wrapper.html()).toContain('<mfp-message')
        expect(wrapper.html()).toContain('class="row mt-4 was-validated pay-receive">')
        expect(wrapper.html()).toContain('class="col-4 money">')
        expect(wrapper.html()).toContain('<input-money')
        expect(wrapper.html()).toContain('customclasscol="col-12" customclassrow="" customclassform="" showtitle="false" title="Valor" masked="false" precision="2" decimal="," thousands="." suffix="" usefloatinglabels="false" value="100.5"></input-money')
        expect(wrapper.html()).toContain('class="col-5 form-group">')
        expect(wrapper.html()).toContain('class="form-select" required="">')
        expect(wrapper.html()).toContain('disabled="" value="0">Selecione uma carteira</option>')
        expect(wrapper.html()).toContain('class="col-2 mt-2 switch">')
        expect(wrapper.html()).toContain('class="form-check form-switch"><label')
        expect(wrapper.html()).toContain('class="form-check-label" for="partial">partialLabel active by vitest</label><input ')
        expect(wrapper.html()).toContain('class="form-check-input" type="checkbox" role="switch" id="partial"></div>')
        expect(wrapper.html()).toContain('class="col-1 button-group" style="margin-top: -25px;"><button')
        expect(wrapper.html()).toContain('class="btn btn-success rounded-2 me-2" disabled="" style="display: none;">')
        expect(wrapper.html()).toContain('icon="fas,check"></font-awesome')
        expect(wrapper.html()).toContain('class="btn btn-success rounded-2 me-2">')
        expect(wrapper.html()).toContain('icon="fas,check"></font-awesome')
        expect(wrapper.html()).toContain('class="btn btn-danger rounded-2">')
        expect(wrapper.html()).toContain('icon="fas,xmark"></font-awesome')
        expect(wrapper.html()).toContain('class="mt-4" style="display: none;">')
        expect(wrapper.html()).toContain('messagetype="alert-danger" messagetext="Falta - para poder utilizar essa carteira como pagamento para essa conta."></mfp-alert-message')
    })
})