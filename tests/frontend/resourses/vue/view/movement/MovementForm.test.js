import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import MovementForm from '~vue/view/movement/MovementForm.vue'
import ApiRouter from "~js/router/apiRouter";

describe('Testing the form from movement render', () => {
    it('should render form to insert new movement', async () => {
        vitest.spyOn(ApiRouter.wallet, 'index').mockImplementation(async () => {
            return []
        })

        const mockRoute = {
            params: {
                id: undefined
            }
        }

        const wrapper = shallowMount(MovementForm, {
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

        expect(wrapper.html()).toContain('<mfp-message-stub ')
        expect(wrapper.html()).toContain(' class="was-validated text-black mt-4">')
        expect(wrapper.html()).toContain('class="row justify-content-center"')
        expect(wrapper.html()).toContain('type="text" class="form-control" id="description-input" placeholder="" minlength="2" required="">')
        expect(wrapper.html()).toContain('"description-input">Descrição</label></div>')
        expect(wrapper.html()).toContain('class="row justify-content-center mt-3">')
        expect(wrapper.html()).toContain('class="form-select" id="select-type" required=""></select>')
        expect(wrapper.html()).toContain('for="select-type">Tipo</label></div>')
        expect(wrapper.html()).toContain('class="form-select" id="select-wallet" required="">')
        expect(wrapper.html()).toContain('disabled="" value="0">Selecione uma Carteira</option>')
        expect(wrapper.html()).toContain('for="select-wallet">Carteira</label></div>')
        expect(wrapper.html()).toContain('customclasscol="col-4" customclassrow="justify-content-center" customclassform="mt-2" showtitle="true" title="Valor" masked="false" precision="2" decimal=","')
        expect(wrapper.html()).toContain('thousands="." suffix="" usefloatinglabels="true" class="mt-2" value="0"></input-money-stub>')
        expect(wrapper.html()).toContain('redirectto="/movimentacoes" buttonsuccesstext="" buttonsuccessicon="fas,check" buttoncanceltext="Voltar" buttoncancelicon="fas,angle-left"')
        expect(wrapper.html()).toContain('showbuttoncancel="true"></bottom-buttons-stub>')
        expect(wrapper.html()).toContain('</divider-stub>')
    })
})