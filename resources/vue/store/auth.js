import { ref } from 'vue'
import { defineStore } from 'pinia'
import routerNonAuthenticated from "../../js/router/routerNonAuthenticated";
import RequestTools from "../../js/tools/requestTools";

export const userAuthStore = defineStore('auth', () => {
    const token = ref(RequestTools.storage.getStorageItem('mfp-token'))
    const user = ref(RequestTools.storage.getStorageItem('mfp-user'))

    function setToken(tokenValue) {
        RequestTools.storage.setStorageItem('mfp-token', tokenValue)
        token.value = tokenValue
    }

    function setUser(userValue) {
        RequestTools.storage.setStorageItem('mfp-user', userValue)
        user.value = userValue
    }

    async function checkToken() {
        const {data} = await routerNonAuthenticated.auth.verify(token.value)
        return data
    }

    function isAuthUser() {
        let isTokenInSessionStorage = RequestTools.storage.getStorageItem('mfp-token')
        let isUserInSessionStorage = RequestTools.storage.getStorageItem('mfp-user')
        return token.value && user.value && isTokenInSessionStorage && isUserInSessionStorage
    }

    function logout() {
        RequestTools.storage.removeStorageItems('mfp-token', 'mfp-user')
        user.value = null
        token.value = null
    }

    return {setToken, setUser, checkToken, logout, isAuthUser, token, user}
})