import {describe, it, expect} from "vitest"
import { shallowMount } from '@vue/test-utils'
import MfpRefresh from "../../../../src/components/refresh/MfpRefresh.vue"

describe("test MfpRefresher render", () => {
    it("test render", async () => {
        const wrapper = shallowMount(MfpRefresh, {
            propsData: {
                customClass: 'custom-class',
            }
        })

        expect(wrapper.html()).toContain('<ion-refresher-stub routerlink="Symbol()" pullmin="Symbol()" pullmax="Symbol()" closeduration="Symbol()" snapbackduration="Symbol()" pullfactor="Symbol()" disabled="Symbol()" ionrefresh="Symbol()" ionpull="Symbol()" ionstart="Symbol()" slot="fixed"')
    })
})