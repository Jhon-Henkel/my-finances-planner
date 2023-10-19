import { userAuthStore } from '../../vue/store/auth'
import requestTools from '../tools/requestTools'

const apiRouter = {
    wallet: {
        index: async function() {
            const request = await requestTools.request.get('/api/wallet')
            return request.data
        },
        show: async function(id) {
            const request = await requestTools.request.get('/api/wallet/' + id)
            return request.data
        },
        insert: async function(wallet) {
            return await requestTools.request.post('/api/wallet', wallet)
        },
        update: async function(wallet, id) {
            return await requestTools.request.put('/api/wallet/' + id, wallet)
        },
        delete: async function(id) {
            return await requestTools.request.delete('/api/wallet/' + id)
        }
    },
    cards: {
        index: async function() {
            const request = await requestTools.request.get('/api/credit-card')
            return request.data
        },
        show: async function(id) {
            const request = await requestTools.request.get('/api/credit-card/' + id)
            return request.data
        },
        insert: async function(card) {
            return await requestTools.request.post('/api/credit-card', card)
        },
        update: async function(card, id) {
            return await requestTools.request.put('/api/credit-card/' + id, card)
        },
        delete: async function(id) {
            return await requestTools.request.delete('/api/credit-card/' + id)
        },
        invoices: {
            index: async function(cardId) {
                const request = await requestTools.request.get('/api/credit-card/' + cardId + '/invoices')
                return request.data
            },
            payInvoice: async function(walletId, cardId) {
                return await requestTools.request.put('/api/credit-card/' + cardId + '/invoices/' + walletId)
            }
        }
    },
    expense: {
        index: async function() {
            const request = await requestTools.request.get('/api/credit-card/transaction')
            return request.data
        },
        show: async function(id) {
            const request = await requestTools.request.get('/api/credit-card/transaction/' + id)
            return request.data
        },
        insert: async function(expense) {
            return await requestTools.request.post('/api/credit-card/transaction', expense)
        },
        update: async function(expense, id) {
            return await requestTools.request.put('/api/credit-card/transaction/' + id, expense)
        },
        delete: async function(id) {
            return await requestTools.request.delete('/api/credit-card/transaction/' + id)
        }
    },
    movement: {
        indexFiltered: async function(quest) {
            if (quest === undefined) {
                quest = ''
            }
            const request = await requestTools.request.get('/api/movement/filter/' + quest)
            return request.data
        },
        delete: async function(id) {
            return await requestTools.request.delete('/api/movement/' + id)
        },
        show: async function(id) {
            const request = await requestTools.request.get('/api/movement/' + id)
            return request.data
        },
        insert: async function(movement) {
            return await requestTools.request.post('/api/movement', movement)
        },
        update: async function(movement, id) {
            return await requestTools.request.put('/api/movement/' + id, movement)
        },
        insertTransfer: async function(transfer) {
            return await requestTools.request.post('/api/movement/transfer', transfer)
        },
        deleteTransfer: async function(id) {
            return await requestTools.request.delete('/api/movement/transfer/' + id)
        }
    },
    userActions: {
        logout: async function() {
            userAuthStore().logout()
            return await requestTools.request.get('/logout')
        }
    },
    futureGain: {
        getNextSixMonthsGains: async function() {
            const request = await requestTools.request.get('/api/future-gain/next-six-months')
            return request.data
        },
        delete: async function(id) {
            return await requestTools.request.delete('/api/future-gain/' + id)
        },
        receive: async function(id, data) {
            return await requestTools.request.post('/api/future-gain/' + id + '/receive', data)
        },
        show: async function(id) {
            const request = await requestTools.request.get('/api/future-gain/' + id)
            return request.data
        },
        insert: async function(futureGain) {
            return await requestTools.request.post('/api/future-gain', futureGain)
        },
        update: async function(futureGain, id) {
            return await requestTools.request.put('/api/future-gain/' + id, futureGain)
        },
        index: async function() {
            const request = await requestTools.request.get('/api/future-gain')
            return request.data
        }
    },
    futureSpent: {
        delete: async function(id) {
            return await requestTools.request.delete('/api/future-spent/' + id)
        },
        pay: async function(id, data) {
            return await requestTools.request.post('/api/future-spent/' + id + '/pay', data)
        },
        show: async function(id) {
            const request = await requestTools.request.get('/api/future-spent/' + id)
            return request.data
        },
        insert: async function(futureSpent) {
            return await requestTools.request.post('/api/future-spent', futureSpent)
        },
        update: async function(futureSpent, id) {
            return await requestTools.request.put('/api/future-spent/' + id, futureSpent)
        },
        index: async function() {
            const request = await requestTools.request.get('/api/future-spent')
            return request.data
        }
    },
    dashboard: {
        index: async function() {
            const request = await requestTools.request.get('/api/dashboard')
            return request.data
        }
    },
    configurations: {
        update: async function(config, data) {
            return await requestTools.request.put('/api/configurations/' + config, data)
        }
    },
    user: {
        show: async function(id) {
            const request = await requestTools.request.get('/api/user/' + id)
            return request.data
        },
        update: async function(id, user) {
            return await requestTools.request.put('/api/user/' + id, user)
        }
    },
    panorama: {
        index: async function() {
            const request = await requestTools.request.get('/api/panorama')
            return request.data
        }
    },
    financialHealth: {
        indexFiltered: async function(quest) {
            if (quest === undefined) {
                quest = ''
            }
            const request = await requestTools.request.get('/api/financial-health/filter/' + quest)
            return request.data
        }
    },
    monthlyClosing: {
        indexFiltered: async function(quest) {
            if (quest === undefined) {
                quest = ''
            }
            const request = await requestTools.request.get('/api/monthly-closing/filter/' + quest)
            return request.data
        }
    }
}

export default apiRouter