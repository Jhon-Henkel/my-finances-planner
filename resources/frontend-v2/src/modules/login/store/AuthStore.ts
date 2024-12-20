import {defineStore} from "pinia"
import {Ref, ref} from "vue"
import {UtilTime} from "@/modules/@shared/util/UtilTime"
import {UtilCookies} from "@/modules/@shared/util/UtilCookies"

export const useAuthStore = defineStore('auth', {
    state: (): { token: any, user: any | null } => ({
        token: ref(UtilCookies.getCookie('mfp-token')) ?? null,
        user: ref(UtilCookies.getCookieObject('mfp-user')) ?? null,
    }),
    actions: {
        setToken(tokenValue: string): void {
            UtilCookies.setCookie('mfp-token', tokenValue, UtilTime.getThreeHoursInMs())
            this.token = tokenValue
        },
        setUser(userValue: string): void {
            UtilCookies.setCookieObject('mfp-user', userValue, UtilTime.getThreeHoursInMs())
            this.user = userValue
        },
        logout(): void {
            if (this.user) {
                this.user.plan = null
            }
            UtilCookies.removeCookie('mfp-token')
        },
        isAuthUser(): boolean {
            const sessionToken = UtilCookies.getCookie('mfp-token')
            const sessionUser = UtilCookies.getCookieObject('mfp-user')
            const auth = sessionToken && sessionUser
            if (!auth) {
                this.logout()
                return false
            }
            if (sessionToken !== this.token || sessionUser !== this.user) {
                this.token = sessionToken
                this.user = sessionUser
            }
            return true
        }
    },
    getters: {
        getToken(): Ref<string> {
            return ref(this.token ??  '')
        },
        getEmail(): Ref<string> {
            return ref(this.user?.email ?? '')
        },
        getUserId(): Ref<number> {
            return ref(this.user?.id ?? 0)
        }
    },
})
