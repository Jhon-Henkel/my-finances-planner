import { describe, it, expect } from 'vitest'
import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import BackButton from '~vue-component/buttons/BackButton.vue'

describe('Testing the BackButton', () => {
    it('renders back button', () => {
        const wrapper = shallowMount(BackButton, {
            propsData: {
                to: '/tools'
            },
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                }
            }
        })
        expect(wrapper.html()).toContain('class="btn btn-success rounded-2')
        expect(wrapper.html()).toContain('icon="fas,angle-left"')
        expect(wrapper.html()).toContain('> Voltar')
    })
})