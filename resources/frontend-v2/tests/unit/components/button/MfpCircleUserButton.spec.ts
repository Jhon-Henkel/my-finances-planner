import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpCircleUserButton from "../../../../src/components/button/MfpCircleUserButton.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpCircleUserButton)

        expect(wrapper.html()).toContain('<ion-button-stub routerlink="')
    })
})