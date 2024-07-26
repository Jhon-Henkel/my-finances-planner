import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpCirclePlusButton from "../../../../src/components/button/MfpCirclePlusButton.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpCirclePlusButton)

        expect(wrapper.html()).toContain('<ion-button-stub routerlink="')
    })
})