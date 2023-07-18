import { describe, it, expect } from 'vitest'
import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import filterTopRight from '../../../../../resources/vue/components/filters/filterTopRight.vue'
import MovementEnum from "../../../../../resources/js/enums/movementEnum";

describe('Testing the filterTopRight', () => {
    it('renders filterTopRight', async () => {
        const wrapper = shallowMount(filterTopRight, {
            propsData: {
                filter: MovementEnum.getFilterList()
            },
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                }
            }
        })
        expect(wrapper.html()).toContain('class="form-select form-select-sm"')
        expect(wrapper.html()).toContain('icon="fas,filter-circle-dollar"')

        await wrapper.find('select.form-select').trigger('change')
        expect(wrapper.emitted('callbackMethod').length).toBe(1)
    })
})