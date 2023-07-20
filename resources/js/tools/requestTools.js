import CalendarTools from "./calendarTools";

const RequestTools = {
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