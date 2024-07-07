import {defineStore} from "pinia"
import {Ref, ref} from "vue"
import {UtilTime} from "@/util/UtilTime"
import {localStorageCache} from '@jhowrf/local-storage-cache/src/localStorageCache'

export const useAuthStore = defineStore({
    id: 'auth',
    state: (): { token: any, email: any | null } => ({
        token: ref(localStorageCache.getStorageItem('mfp-token')) ?? null,
        email: ref(localStorageCache.getStorageItem('mfp-user')) ?? null,
    }),
    actions: {
        setToken(tokenValue: string): void {
            localStorageCache.setStorageItem('mfp-token', tokenValue, UtilTime.getThreeHoursInMs())
            this.token = tokenValue
        },
        setUser(userValue: string): void {
            localStorageCache.setStorageItem('mfp-user', userValue, UtilTime.getOneYearInMs())
            this.email = userValue
        },
        logout(): void {
            localStorageCache.removeStorageItems('mfp-token')
        },
        isAuthUser(): boolean {
            const isTokenInSessionStorage = localStorageCache.getStorageItem('mfp-token')
            const isUserInSessionStorage = localStorageCache.getStorageItem('mfp-user')
            return this.token && this.email && isTokenInSessionStorage && isUserInSessionStorage
        }
    },
    getters: {
        getToken(): Ref<string | null> {
            return ref(this.token)
        },
        getEmail(): Ref<string | null> {
            return ref(this.email)
        },
    },
})
