import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import ApiRouter from '~js/router/apiRouter'
import ManageCardsView from '~vue/view/creditCard/ManageCardsView.vue'

describe('Testing the manage cards render', () => {
    it('should render manage cards basic screen view without cards registered', async () => {
        vitest.spyOn(ApiRouter.cards, 'index').mockImplementation(async () => {
            return []
        })

        vitest.spyOn(ApiRouter.wallet, 'index').mockImplementation(async () => {
            return []
        })

        const wrapper = shallowMount(ManageCardsView, {
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
        expect(wrapper.html()).toContain('<mfp-message-stub ')
        expect(wrapper.html()).toContain('<loading-component-stub ')
        expect(wrapper.html()).toContain('class="nav mt-2 justify-content-end">')
        expect(wrapper.html()).toContain('title="Cartões"></mfp-title-stub>')
        expect(wrapper.html()).toContain('<mfp-drop-down-button-stub ')
        expect(wrapper.html()).toContain('dropdowntitle="Novo" dropdownicon="fas,circle-plus" alignitenscenter="true"></mfp-drop-down-button-stub>')
        expect(wrapper.html()).toContain('<divider-stub ')
        expect(wrapper.html()).toContain('class="glass card mb-2">')
        expect(wrapper.html()).toContain('class="col-12 text-center"> Você não possui nenhum cartão cadastrado! </div>')
        expect(wrapper.html()).toContain('class="form-select card-select-to-pay" id="pay-invoice" disabled="" style="display: none;">')
        expect(wrapper.html()).toContain('<option data-v-5bf0dfc0="" disabled="" value="0">Selecione a carteira</option>')
    })
})