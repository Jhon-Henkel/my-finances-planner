import { describe, it, expect } from 'vitest'
import { shallowMount } from '@vue/test-utils'
import LoadingComponent from '../../../../resources/vue/components/LoadingComponent.vue'

describe('Testing the LoadingComponent', () => {
    it('should render button', () => {
        const wrapper = shallowMount(LoadingComponent)
        expect(wrapper.html()).toContain('success mb-2" role="status">')
        expect(wrapper.html()).toContain('hidden">Loading...</span>')
    })
})