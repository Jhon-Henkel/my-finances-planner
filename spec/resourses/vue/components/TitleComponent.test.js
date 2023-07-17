import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import TitleComponent from '../../../../resources/vue/components/TitleComponent.vue'

describe('Testing the TitleComponent', () => {
    it('should render title', () => {
        const wrapper = mount(TitleComponent, {
            propsData: {
                title: 'Hello World'
            }
        })
        expect(wrapper.html()).toContain('Hello World')
    })
})