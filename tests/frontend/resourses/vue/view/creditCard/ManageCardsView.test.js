import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import ApiRouter from "~js/router/apiRouter";
import ManageCardsView from "~vue/view/creditCard/ManageCardsView.vue";

describe('Testing the manage cards basic render', () => {
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
        expect(wrapper.html()).toContain('class="col-12 text-center mt-4 mb-4"> Você não possui nenhum cartão cadastrado! </div>')
    })
})