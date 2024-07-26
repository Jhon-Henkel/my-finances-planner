import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpCounterMoney from "../../../../src/components/counter/MfpCounterMoney.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpCounterMoney, {
            propsData: {
                start: 0,
                end: 100,
                duration: 1,
            }
        })

        expect(wrapper.html()).toContain('<vue3-autocounter-stub startamount="0" endamount="100" duration="1" autoinit="true" suffix="" separator="." decimalseparator="," decimals="2"></vue3-autocounter-stub>')
    })
})