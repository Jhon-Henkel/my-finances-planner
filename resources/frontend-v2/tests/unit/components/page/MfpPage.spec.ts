import {beforeEach, describe, expect, it, vitest} from "vitest"
import {shallowMount} from '@vue/test-utils'
import MfpPage from "../../../../src/modules/@shared/components/page/MfpPage.vue"

describe('test render component', () => {
    beforeEach(() => {
        vitest.mock('../../../../src/modules/login/store/AuthStore', () => ({
            useAuthStore: () => {
                return {
                    setToken: vitest.fn(),
                    setUser: vitest.fn(),
                    logout: vitest.fn(),
                    getToken: vitest.fn(),
                    getEmail: vitest.fn(),
                    getUserId: vitest.fn(),
                    isAuthUser: vitest.fn(function () {
                        return true
                    }),
                    user: 'email_vitest',
                    token: 'token_vitest',
                }
            }
        }))
    })

    it("render base component", async () => {
        const wrapper = shallowMount(MfpPage)

        expect(wrapper.html()).toContain('registerionpage="[Function]" class="ion-margin-top ion-padding-top"></ion-page-stub>')
    })
})
