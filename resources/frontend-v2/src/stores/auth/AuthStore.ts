import {defineStore} from "pinia"
import {Ref, ref} from "vue"
import {UtilTime} from "@/util/UtilTime"
import {localStorageCache} from '@jhowrf/local-storage-cache/src/localStorageCache'

export const useAuthStore = defineStore({
    id: 'auth',
    state: (): { token: any, user: any | null } => ({
        token: ref(localStorageCache.getStorageItem('mfp-token')) ?? null,
        user: ref(localStorageCache.getStorageItem('mfp-user')) ?? null,
    }),
    actions: {
        setToken(tokenValue: string): void {
            localStorageCache.setStorageItem('mfp-token', tokenValue, UtilTime.getThreeHoursInMs())
            this.token = tokenValue
        },
        setUser(userValue: string): void {
            localStorageCache.setStorageItem('mfp-user', userValue, UtilTime.getThreeHoursInMs())
            this.user = userValue
        },
        logout(): void {
            localStorageCache.removeStorageItems('mfp-token')
        },
        isAuthUser(): boolean {
            const sessionToken = localStorageCache.getStorageItem('mfp-token')
            const sessionUser = localStorageCache.getStorageItem('mfp-user')
            const auth = sessionToken && sessionUser
            if (!auth) {
                this.logout()
                return false
            }
            this.token = sessionToken
            this.user = sessionUser
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
