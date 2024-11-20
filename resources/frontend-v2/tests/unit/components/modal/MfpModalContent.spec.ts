import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpModalContent from "../../../../src/modules/@shared/components/modal/MfpModalContent.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpModalContent, {
            propsData: {
                showContent: true,
            }
        })

        expect(wrapper.html()).toContain('<ion-content-stub ')
    })
})
