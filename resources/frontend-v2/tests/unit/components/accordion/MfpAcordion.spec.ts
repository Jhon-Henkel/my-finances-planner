import {describe, it, expect } from "vitest"
import { shallowMount } from '@vue/test-utils'
import MfpAccordion from "../../../../src/modules/@shared/components/accordion/MfpAccordion.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpAccordion, {
            propsData: {
                title: 'Vitest Title',
                value: 'first',
            }
        })

        expect(wrapper.html()).toContain('value="first"></ion-accordion-stub>')
    })
})
