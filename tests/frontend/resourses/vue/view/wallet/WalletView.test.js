import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import ApiRouter from '~js/router/apiRouter'
import WallerView from '~vue/view/wallet/WalletView.vue'

describe('Testing the wallets list render', () => {
    it('should render list wallets basic screen view without wallets registered', async () => {
        vitest.spyOn(ApiRouter.wallet, 'index').mockImplementation(async () => {
            return []
        })

        const wrapper = shallowMount(WallerView, {
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

        expect(wrapper.html()).toContain('class="base-container">')
        expect(wrapper.html()).toContain('<mfp-message-stub ')
        expect(wrapper.html()).toContain('<loading-component-stub')
        expect(wrapper.html()).toContain('<loading-component-stub')
        expect(wrapper.html()).toContain('class="nav mt-2 justify-content-end">')
        expect(wrapper.html()).toContain('class="btn btn-success rounded-2 top-button">')
        expect(wrapper.html()).toContain('title="Carteiras"></mfp-title-stub>')
        expect(wrapper.html()).toContain('</font-awesome-icon-stub> Nova Carteira')
        expect(wrapper.html()).toContain('</divider-stub>')
        expect(wrapper.html()).toContain('>Nenhuma carteira cadastrada ainda!</span>')
        expect(wrapper.html()).toContain('class="col-2">-</div>')
    })
})