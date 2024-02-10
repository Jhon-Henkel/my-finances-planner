import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import MovementTransferForm from '~vue/view/movement/MovementTransferForm.vue'
import ApiRouter from "~js/router/apiRouter";

describe('Testing the transfer form from movement render', () => {
    it('should render transfer  form to insert new transfer  movement', async () => {
        vitest.spyOn(ApiRouter.wallet, 'index').mockImplementation(async () => {
            return []
        })

        const wrapper = shallowMount(MovementTransferForm, {
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                },
                directives: {
                    tooltip: true
                }
            }
        })

        expect(wrapper.html()).toContain('<mfp-message-stub ')
        expect(wrapper.html()).toContain('time="100"></loading-component-stub>')
        expect(wrapper.html()).toContain('title="Cadastrar Transferência" class="title"></mfp-title-stub>')
        expect(wrapper.html()).toContain('class="was-validated mt-4 text-black">')
        expect(wrapper.html()).toContain('customclasscol="col-4" customclassrow="justify-content-center" customclassform="mt-2" showtitle="true" title="Valor" masked="false" precision="2" decimal="," thousands="." suffix="" usefloatinglabels="true" value="0"></input-money-stub>')
        expect(wrapper.html()).toContain('class="form-select" id="origin" required="">')
        expect(wrapper.html()).toContain('value="0">Selecione uma carteira de origem</option>')
        expect(wrapper.html()).toContain('for="origin">Carteira Origem</label></div>')
        expect(wrapper.html()).toContain('icon="fas,circle-arrow-down" border="false" fixedwidth="false" flip="false" listitem="false" pulse="false" swapopacity="false" spin="false" symbol="false" inverse="false" bounce="false" shake="false" beat="false" fade="false" beatfade="false" flash="false" spinpulse="false" spinreverse="false" class="transfer-icon"></font-awesome-icon-stub>')
        expect(wrapper.html()).toContain('class="form-select" id="destination" required="">')
        expect(wrapper.html()).toContain(' disabled="" value="0">Selecione uma carteira de destino</option>')
        expect(wrapper.html()).toContain('for="destination">Carteira Origem</label></div>')
        expect(wrapper.html()).toContain('redirectto="/movimentacoes" buttonsuccesstext="Cadastrar Transferência" buttonsuccessicon="fas,check" buttoncanceltext="Voltar" buttoncancelicon="fas,angle-left" showbuttoncancel="true"></bottom-buttons-stub>')
    })
})