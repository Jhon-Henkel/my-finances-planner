import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpInput from "../../../../src/modules/@shared/components/input/MfpInput.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpInput, {
            propsData: {
                label: 'Test Label Vitest',
                placeholder: 'Test Placeholder Vitest',
                clearInput: true,
                required: true,
            }
        })

        expect(wrapper.html()).toContain('<ion-item-stub routerlink=')
    })
})
