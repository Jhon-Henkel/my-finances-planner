import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpCircleCheckButton from "../../../../src/components/button/MfpCircleCheckButton.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpCircleCheckButton)

        expect(wrapper.html()).toContain('<ion-button-stub routerlink="')
    })
})