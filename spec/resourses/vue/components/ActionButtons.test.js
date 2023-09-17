import { describe, it, expect } from 'vitest'
import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import ActionButtons from '../../../../resources/vue/components/ActionButtons.vue'

describe('Testing the ActionButtons', () => {
    it('should render buttons with all buttons', async() => {
        const wrapper = shallowMount(ActionButtons, {
            propsData: {
                editTo: '/edit',
                editIcon: ['editIcon'],
                tooltipEdit: 'editTooltip',
                deleteIcon: ['deleteIcon'],
                deleteTooltip: 'deleteTooltip',
                showInfoButton: true,
                infoIcon: ['infoIcon'],
                infoTo: '/info',
                infoTooltip: 'infoTooltip',
                checkButton: true,
                checkTooltip: 'checkTooltip',
                checkIcon: ['checkIcon'],
            },
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true
                },
                directives: {
                    tooltip: true
                }
            }
        })
        expect(wrapper.html()).toContain('class="text-center action-buttons">')
        expect(wrapper.html()).toContain('class="btn btn-sm btn-danger rounded-2"')
        expect(wrapper.html()).toContain('class="btn btn-sm btn-success rounded-2 me-1"')
        expect(wrapper.html()).toContain('class="btn btn-sm btn-success rounded-2 me-1"')
        expect(wrapper.html()).toContain('class="btn btn-sm btn-info rounded-2 me-1"')

        await wrapper.find('button.btn-success').trigger('click')
        expect(wrapper.emitted('check-clicked').length).toBe(1)

        await wrapper.find('button.btn-danger').trigger('click')
        expect(wrapper.emitted('delete-clicked').length).toBe(1)
    })
})