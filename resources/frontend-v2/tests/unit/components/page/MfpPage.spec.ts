import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpPage from "../../../../src/components/page/MfpPage.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpPage)

        expect(wrapper.html()).toContain('<ion-page-stub registerionpage="[Function]" class="ion-margin-top ion-padding-top"></ion-page-stub>')
    })
})