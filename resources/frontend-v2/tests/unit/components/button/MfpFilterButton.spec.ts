import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpFilterButton from "../../../../src/modules/@shared/components/button/MfpFilterButton.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpFilterButton)

        expect(wrapper.html()).toContain('<ion-button-stub routerlink="')
    })
})
