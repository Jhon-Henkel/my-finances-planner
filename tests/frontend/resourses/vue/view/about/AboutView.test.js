import { describe, it, expect } from 'vitest'
import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import AboutView from '~vue/view/about/AboutView.vue'

describe('Testing the AboutView', () => {
    it('should render the AboutView', async() => {
        const wrapper = shallowMount(AboutView, {
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true
                }
            }
        })
        expect(wrapper.html()).toContain('Caso queira entrar em contato comigo, você pode me enviar um e-mail para')
        expect(wrapper.html()).toContain('href="/login" target="_blank" class="link">clicar aqui')
        expect(wrapper.html()).toContain('href="https://www.jhon.dev.br" target="_blank" class="link"')
    })
})