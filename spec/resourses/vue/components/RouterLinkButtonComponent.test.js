import { describe, it, expect } from 'vitest'
import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import RouterLinkButtonComponent from '../../../../resources/vue/components/RouterLinkButtonComponent.vue'

describe('Testing the RouterLinkButtonComponent', () => {
    it('should render button', () => {
        const wrapper = shallowMount(RouterLinkButtonComponent, {
            propsData: {
                redirectTo: '/home',
                title: 'Home Title',
                icon: ['fas', 'home']
            },
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true
                }
            }
        })
        expect(wrapper.html()).toContain('class="btn btn-success rounded-5"')
        expect(wrapper.html()).toContain('Home Title')
    })
})