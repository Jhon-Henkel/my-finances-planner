import { describe, it, expect } from 'vitest'
import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import BottomButtons from '../../../../resources/vue/components/BottomButtons.vue'

describe('Testing the BottomButtons', () => {
    it('should render buttons with cancel button', async() => {
        const wrapper = shallowMount(BottomButtons, {
            propsData: {
                buttonSuccessText: 'SuccessButton',
                buttonSuccessIcon: ['successIcon'],
                buttonCancelText: 'CancelButton',
                buttonCancelIcon: ['cancelIcon'],
                redirectTo: '/redirect',
                showButtonCancel: true
            },
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true
                }
            }
        })
        expect(wrapper.html()).toContain('"nav justify-content-center">')
        expect(wrapper.html()).toContain('SuccessButton')
        expect(wrapper.html()).toContain('CancelButton')

        await wrapper.find('button.btn-success').trigger('click')
        expect(wrapper.emitted('btn-clicked').length).toBe(1)
    })

    it('should render buttons without cancel button', async() => {
        const wrapper = shallowMount(BottomButtons, {
            propsData: {
                buttonSuccessText: 'SuccessButton',
                buttonSuccessIcon: ['successIcon'],
                buttonCancelText: 'CancelButton',
                buttonCancelIcon: ['cancelIcon'],
                redirectTo: '/redirect',
                showButtonCancel: false
            },
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true
                }
            }
        })
        expect(wrapper.html()).toContain('"nav justify-content-center">')
        expect(wrapper.html()).toContain('SuccessButton')
        expect(wrapper.html()).not.contain('CancelButton')

        await wrapper.find('button.btn-success').trigger('click')
        expect(wrapper.emitted('btn-clicked').length).toBe(1)
    })
})