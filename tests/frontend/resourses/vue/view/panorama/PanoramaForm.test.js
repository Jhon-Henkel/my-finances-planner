import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import ApiRouter from '~js/router/apiRouter'
import PanoramaForm from '~vue/view/panorama/PanoramaForm.vue'

describe('Testing the future spent form render', () => {
    it('should render form for insert one future spent', async () => {
        vitest.spyOn(ApiRouter.wallet, 'index').mockImplementation(async () => {
            return []
        })

        const mockRoute = {
            params: {
                id: undefined
            },
            query: {
                referer: undefined
            }
        }

        const wrapper = shallowMount(PanoramaForm, {
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

        expect(wrapper.html()).toContain('class="base-container">')
        expect(wrapper.html()).toContain('</mfp-message-stub>')
        expect(wrapper.html()).toContain('time="100"></loading-component-stub>')
        expect(wrapper.html()).toContain('</mfp-title-stub>')
        expect(wrapper.html()).toContain('</divider-stub>')
        expect(wrapper.html()).toContain('class="was-validated form-floating text-black">')
        expect(wrapper.html()).toContain('type="text" class="form-control" id="description-input" placeholder="" minlength="2" required="">')
        expect(wrapper.html()).toContain('for="description-input">Descrição</label></div>')
        expect(wrapper.html()).toContain('type="date" class="form-control" id="first-installment" placeholder="" required="">')
        expect(wrapper.html()).toContain('for="first-installment">Primeira Parcela</label></div>')
        expect(wrapper.html()).toContain('class="row justify-content-center mt-3">')
        expect(wrapper.html()).toContain('class="form-select" id="wallet" required="">')
        expect(wrapper.html()).toContain('value="0">Selecione uma carteira</option>')
        expect(wrapper.html()).toContain('for="wallet">Carteira</label></div>')
        expect(wrapper.html()).toContain('buttonsuccesstext="" buttonsuccessicon="fas,check" buttoncanceltext="Voltar" buttoncancelicon="fas,angle-left" showbuttoncancel="true"></bottom-buttons-stub>')
    })
})