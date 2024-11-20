import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpInfoButton from "../../../../src/modules/@shared/components/button/MfpInfoButton.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpInfoButton)

        expect(wrapper.html()).toContain('<ion-button-stub routerlink="')
    })
})
