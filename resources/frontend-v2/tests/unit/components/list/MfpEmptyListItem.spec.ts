import {describe, it, expect} from "vitest"
import { shallowMount } from '@vue/test-utils'
import MfpEmptyListItem from "../../../../src/components/list/MfpEmptyListItem.vue"

describe("test MfpEmptyListItem render", () => {
    it("test render with nothing to show equals a true", async () => {
        const wrapper = shallowMount(MfpEmptyListItem, {
            propsData: {
                nothingToShow: true
            }
        })

        expect(wrapper.html()).toContain("class=\"ion-text-center\"></ion-item-stub>")
    })

    it("test render with nothing to show equals a false", async () => {
        const wrapper = shallowMount(MfpEmptyListItem, {
            propsData: {
                nothingToShow: false
            }
        })

        expect(wrapper.html()).toContain("<!--v-if-->")
    })
})