import { describe, it, expect } from 'vitest'
import { shallowMount } from '@vue/test-utils'
import AlertIcon from '~vue-component/AlertIcon.vue'

describe('Testing the AlertIcon', () => {
    it('should render button', () => {
        const wrapper = shallowMount(AlertIcon, {
            propsData: {
                icon: ['successIcon'],
                message: 'message'
            },
            global: {
                stubs: {
                    'font-awesome-icon': '<i></i>',
                }
            }
        })
        expect(wrapper.html()).toContain('title="Atenção, valor negativo!"')
        expect(wrapper.html()).toContain('class="icon-alert"')
    })
})