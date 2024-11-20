import {describe, expect, it} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpTotalRegistersRow from "../../../../src/modules/@shared/components/page/MfpTotalRegistersRow.vue"

describe('test render component', () => {
    it("render base component", async () => {
        const wrapper = shallowMount(MfpTotalRegistersRow, {
            propsData: {
                totalItens: 10,
            }
        })

        expect(wrapper.html()).toContain('<div class="ion-text-center ion-padding-top ion-padding-bottom">')
        expect(wrapper.html()).toContain('<ion-label-stub routerlink=')
    })
})
