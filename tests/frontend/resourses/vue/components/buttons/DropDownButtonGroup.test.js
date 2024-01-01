import { describe, it, expect } from 'vitest'
import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import MfpDropDownButton from '~vue-component/buttons/DropDownButtonGroup.vue'
import IconEnum from '~js/enums/iconEnum'

describe('Testing the MfpDropDownButton', () => {
    it('renders drop down button', () => {
        const wrapper = shallowMount(MfpDropDownButton, {
            propsData: {
                dropdownIcon: IconEnum.plus(),
                dropdownTitle: 'Novo',
                buttonsArray: [
                    {
                        title: 'Novo Gasto/Ganho',
                        icon: IconEnum.movement(),
                        redirectTo: '/movimentacoes/cadastrar'
                    },
                    {
                        title: 'Nova Transferência',
                            icon: IconEnum.buildingColumns(),
                        redirectTo: '/movimentacoes/transferir'
                    }
                ]
            },
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                }
            }
        })

        expect(wrapper.html()).toContain('class="btn btn-success dropdown-toggle top-button margin-mobile" type="button" data-bs-toggle="dropdown" aria-expanded="false">')
        expect(wrapper.html()).toContain('icon="fas,circle-plus" class="me-2 icon"></font-awesome-icon-stub> Novo')
        expect(wrapper.html()).toContain('title="Novo Gasto/Ganho" icon="fas,money-bill-transfer" redirectto="/movimentacoes/cadastrar" customclass="dropdown-item"></router-link-button-stub>')
        expect(wrapper.html()).toContain('icon="fas,building-columns" redirectto="/movimentacoes/transferir" customclass="dropdown-item"></router-link-button-stub>')
    })
})