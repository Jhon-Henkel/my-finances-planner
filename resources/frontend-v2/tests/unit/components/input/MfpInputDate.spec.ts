import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpInputDate from "../../../../src/modules/@shared/components/input/MfpInputDate.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpInputDate, {
            propsData: {
                label: 'Test Label Date Vitest',
            }
        })

        expect(wrapper.html()).toContain('<ion-item-stub')
        expect(wrapper.html()).toContain('<ion-modal-stub')
    })
})
