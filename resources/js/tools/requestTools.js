import routerNonAuthenticated from "../router/routerNonAuthenticated";
import CalendarTools from "./calendarTools";

const RequestTools = {
    user: {
        getIdUserLogged: async function () {
            return parseInt(localStorage.getItem('userId'))
        },
        async isUserLogged() {
            let isUserLogged = RequestTools.storage.getStorageItem('isUserLogged')
            if (isUserLogged) {
                return isUserLogged
            }
            let isUserLoggedValue = false
            await routerNonAuthenticated.login.isUserLogged().then((response) => {
                if (response.data.isLogged) {
                    RequestTools.storage.setStorageItem('isUserLogged', response.data.isLogged)
                    isUserLoggedValue = true
                }
            })
            return isUserLoggedValue
        }
    },
    storage: {
        getStorageItem: function (key) {
            let itemInStorage = localStorage.getItem(key)
            if (itemInStorage) {
                const itemParsed = JSON.parse(itemInStorage)
                const now = CalendarTools.getToday()
                if (now.getTime() < itemParsed.expiry) {
                    return itemParsed.value
                }
                this.removeStorageItems(key)
            }
            return null
        },
        setStorageItem: function (key, value, expireTimeMs) {
            let expiry = expireTimeMs ?? CalendarTools.threeHoursInMs()
            localStorage.setItem(key, JSON.stringify({
                value: value,
                expiry: CalendarTools.getToday().getTime() + expiry,
            }))
        },
        removeStorageItems: function (...keys) {
            keys.forEach((key) => {
                localStorage.removeItem(key)
            })
        }
    },
    isApplicationInDemoMode: function () {
        if (import.meta.env.VITE_APP_DEMO_MODE === 'true') {
            return true
        }
        return false
    }
}

export default RequestTools;