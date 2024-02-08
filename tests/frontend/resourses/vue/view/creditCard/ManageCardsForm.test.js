import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import ManageCardsFormView from '~vue/view/creditCard/ManageCardsFormView.vue'

describe('Testing the form from manage cards render', () => {
    it('should render form to insert new card', async () => {
        const mockRoute = {
            params: {
                id: undefined
            }
        }

        const wrapper = shallowMount(ManageCardsFormView, {
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
        expect(wrapper.html()).toContain('</loading-component-stub>')
        expect(wrapper.html()).toContain('class="title"></mfp-title-stub>')
        expect(wrapper.html()).toContain('type="text" class="form-control" id="name-input" placeholder="" minlength="2" required="">')
        expect(wrapper.html()).toContain('>Descrição</label></div>')
        expect(wrapper.html()).toContain('customclassrow="justify-content-center" customclassform="mt-2" showtitle="true" title="Limite" masked="false" precision="2" decimal="," thousands="." suffix="" usefloatinglabels="true" value="0"')
        expect(wrapper.html()).toContain('type="number" class="form-control" id="card-closing-day" placeholder="" min="1" max="31" required=""')
        expect(wrapper.html()).toContain('type="number" class="form-control" id="card-closing-day" placeholder="" min="1" max="31" required=""')
        expect(wrapper.html()).toContain('for="card-closing-day">Dia Fechamento Fatura</label></div>')
        expect(wrapper.html()).toContain('type="number" class="form-control" id="card-due-date" placeholder="" min="1" max="31" required=""><label data-v-020c00e7="" for="card-due-date">Dia Vencimento Fatura')
        expect(wrapper.html()).toContain('redirectto="/gerenciar-cartoes" buttonsuccesstext="" buttonsuccessicon="fas,check" buttoncanceltext="Voltar" buttoncancelicon="fas,angle-left" showbuttoncancel="true"></bottom-buttons-stub>')
        expect(wrapper.html()).toContain('></divider-stub>')
    })
})