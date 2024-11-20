import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpInputToggle from "../../../../src/modules/@shared/components/input/MfpInputToggle.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpInputToggle, {
            propsData: {
                label: 'Test Label Money Vitest',
            }
        })

        expect(wrapper.html()).toContain('<ion-item-stub ')
    })
})
