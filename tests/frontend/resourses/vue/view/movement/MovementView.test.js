import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import MovementView from '~vue/view/movement/MovementView.vue'
import ApiRouter from "~js/router/apiRouter";

describe('Testing the movements render', () => {
    it('should render movements screen view without movements registered', async () => {
        vitest.spyOn(ApiRouter.movement, 'indexFiltered').mockImplementation(async () => {
            return []
        })

        const wrapper = shallowMount(MovementView, {
            global: {
                stubs: {
                    'router-link': RouterLinkStub,
                    'font-awesome-icon': true,
                },
                directives: {
                    tooltip: true
                },
            }
        })

        expect(wrapper.html()).toContain('Nenhuma movimentação cadastrada ainda!</span>')
    })
})