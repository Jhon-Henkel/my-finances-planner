import {describe, it, expect } from "vitest"
import { shallowMount } from '@vue/test-utils'
import MfpAccordionGroup from "../../../../src/components/accordion/MfpAccordionGroup.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpAccordionGroup)

        expect(wrapper.html()).toContain('expand="inset"')
        expect(wrapper.html()).toContain('</ion-accordion-group-stub>')
    })
})