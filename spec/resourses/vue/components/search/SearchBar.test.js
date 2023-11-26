import { describe, it, expect } from 'vitest'
import { shallowMount } from '@vue/test-utils'
import SearchBar from '~vue-component/search/SearchBar.vue'

describe('Testing the SearchBar', () => {
    it('should render buttons with all buttons', async() => {
        const wrapper = shallowMount(SearchBar, {
            global: {
                stubs: {
                    'font-awesome-icon': true
                }
            }
        })
        let wrapperHtml = wrapper.html()
        expect(wrapperHtml).toContain('class="input-group search-bar">')
        expect(wrapperHtml).toContain('class="input-group-text"')
        expect(wrapperHtml).toContain('id="inputGroup-sizing-default"><font-awesome-icon')
        expect(wrapperHtml).toContain('type="text" class="form-control" placeholder="Buscar por descrição"></div>')

        await wrapper.find('input.form-control').setValue('teste')
        expect(wrapper.emitted('searchFor').length).toBe(1)
        expect(wrapper.emitted('searchFor').toString()).toBe('teste')
    })
})