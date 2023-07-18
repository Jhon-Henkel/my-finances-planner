import { describe, it, expect } from 'vitest'
import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import SpentIcon from '../../../../../resources/vue/components/icons/SpentIcon.vue'

describe('Testing the GainIcon', () => {
    it('renders GainIcon', async () => {
        const wrapper = shallowMount(SpentIcon, {
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                }
            }
        })
        expect(wrapper.html()).toContain('icon="fas,circle-arrow-down"')
        expect(wrapper.html()).toContain('class="spent-icon"')
    })
})