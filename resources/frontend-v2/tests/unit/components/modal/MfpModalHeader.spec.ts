import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpModalHeader from "../../../../src/components/modal/MfpModalHeader.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpModalHeader, {
            propsData: {
                title: 'Vitest Title',
            }
        })

        expect(wrapper.html()).toContain('<ion-header-stub ')
    })
})