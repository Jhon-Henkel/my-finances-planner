import { describe, it, expect } from 'vitest'
import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import ToolsView from '../../../../../resources/vue/view/tools/ToolsView.vue'

describe('Testing the ToolsView', () => {
    it('renders tools view', () => {
        const wrapper = shallowMount(ToolsView, {
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                    'divider': true,
                    'mfp-title': true,
                    'side-bar-component': true,
                }
            }
        })
        expect(wrapper.html()).toContain('Ferramentas que auxiliam nas suas finanças pessoais')
        expect(wrapper.html()).toContain('class="card-img-top image-card"')
        expect(wrapper.html()).toContain('class="btn btn-success rounded-2 btn-full"')
    })
})