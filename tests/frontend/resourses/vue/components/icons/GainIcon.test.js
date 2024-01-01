import { describe, it, expect } from 'vitest'
import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import GainIcon from '~vue-component/icons/GainIcon.vue'

describe('Testing the GainIcon', () => {
    it('renders GainIcon', async () => {
        const wrapper = shallowMount(GainIcon, {
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                }
            }
        })
        expect(wrapper.html()).toContain('icon="fas,circle-arrow-up"')
        expect(wrapper.html()).toContain('class="gain-icon"')
    })
})