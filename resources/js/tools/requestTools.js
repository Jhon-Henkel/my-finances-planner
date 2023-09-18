import axios from 'axios'
import CalendarTools from './calendarTools'

const RequestTools = {
    storage: {
        getStorageItem: function(key) {
            const itemInStorage = localStorage.getItem(key)
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
        setStorageItem: function(key, value, expireTimeMs) {
            const expiry = expireTimeMs ?? CalendarTools.threeHoursInMs()
            localStorage.setItem(key, JSON.stringify({
                value,
                expiry: CalendarTools.getToday().getTime() + expiry
            }))
        },
        removeStorageItems: function(...keys) {
            keys.forEach((key) => {
                localStorage.removeItem(key)
            })
        }
    },
    isApplicationInDemoMode: function() {
        if (import.meta.env.VITE_APP_DEMO_MODE === 'true') {
            return true
        }
        return false
    },
    request: {
        async get(url) {
            return await axios.get(url, {
                headers: this.getHeaders()
            })
        },
        async post(url, data) {
            return await axios.post(url, data, {
                headers: this.getHeaders()
            })
        },
        async put(url, data) {
            return await axios.put(url, data, {
                headers: this.getHeaders()
            })
        },
        async delete(url) {
            return await axios.delete(url, {
                headers: this.getHeaders()
            })
        },
        getHeaders() {
            return {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'MFP-TOKEN': import.meta.env.VITE_PUSHER_APP_KEY,
                'X-MFP-USER-TOKEN': 'Bearer ' + RequestTools.storage.getStorageItem('mfp-token')
            }
        }
    }
}

export default RequestTools