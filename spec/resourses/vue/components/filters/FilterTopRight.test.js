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
        console.log(wrapper.html())
        expect(wrapper.html()).toContain('type="button" class="btn btn-success me-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">')
        expect(wrapper.html()).toContain('icon="fas,filter-circle-dollar" class="me-2 mt-1 filter"></font-awesome-icon-stub> Filtrar')
        expect(wrapper.html()).toContain('>Rage de data</span>')
        expect(wrapper.html()).toContain('class="me-2 mt-1 filter"')
        expect(wrapper.html()).toContain('icon="fas,filter-circle-dollar"')
        expect(wrapper.html()).toContain('value="0">Todos</option>')
        expect(wrapper.html()).toContain('value="5">Despesa</option>')
        expect(wrapper.html()).toContain('value="6">Receita</option>')
        expect(wrapper.html()).toContain('value="7">Transferência</option>')
    })
})