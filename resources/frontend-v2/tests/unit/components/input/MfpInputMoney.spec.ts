import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpInputMoney from "../../../../src/components/input/MfpInputMoney.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpInputMoney, {
            propsData: {
                label: 'Test Label Money Vitest',
                modelValue: 1000,
            },
            directives: {
                money: {
                    bind: () => {},
                }
            }
        })

        expect(wrapper.html()).toContain('<ion-item-stub ')
    })
})