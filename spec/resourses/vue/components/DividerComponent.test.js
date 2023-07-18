import { describe, it, expect } from 'vitest'
import { shallowMount } from '@vue/test-utils'
import DividerComponent from '../../../../resources/vue/components/DividerComponent.vue'

describe('Testing the DividerComponent', () => {
    it('should render button', () => {
        const wrapper = shallowMount(DividerComponent)
        expect(wrapper.html()).toContain('class="divider mt-4 mb-4">')
        expect(wrapper.html()).toContain('<hr')
    })
})