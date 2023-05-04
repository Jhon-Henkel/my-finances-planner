import RequestTools from "../tools/requestTools";

window.axios.defaults.headers.common['mfp-token'] = import.meta.env.VITE_PUSHER_APP_KEY;

const apiRouter = {
    wallet: {
        index: async function() {
            const request = await axios.get('/api/wallet')
            return request.data
        },
        show: async function(id) {
            const request = await axios.get('/api/wallet/' + id)
            return request.data
        },
        insert: async function(wallet) {
            return await axios.post('/api/wallet', wallet)
        },
        update: async function(wallet, id) {
            return await axios.put('/api/wallet/' + id, wallet)
        },
        delete: async function(id) {
            return await axios.delete('/api/wallet/' + id)
        },
    },
    cards: {
        index: async function() {
            const request = await axios.get('/api/credit-card')
            return request.data
        },
        show: async function(id) {
            const request = await axios.get('/api/credit-card/' + id)
            return request.data
        },
        insert: async function(card) {
            return await axios.post('/api/credit-card', card)
        },
        update: async function(card, id) {
            return await axios.put('/api/credit-card/' + id, card)
        },
        delete: async function(id) {
            return await axios.delete('/api/credit-card/' + id)
        },
        invoices: {
            index: async function(cardId) {
                const request = await axios.get('/api/credit-card/' + cardId + '/invoices')
                return request.data
            },
            payInvoice: async function(walletId, cardId) {
                return await axios.put('/api/credit-card/' + cardId + '/invoices/' + walletId)
            }
        }
    },
    expense: {
        index: async function() {
            const request = await axios.get('/api/credit-card/transaction')
            return request.data
        },
        show: async function(id) {
            const request = await axios.get('/api/credit-card/transaction/' + id)
            return request.data
        },
        insert: async function(expense) {
            return await axios.post('/api/credit-card/transaction', expense)
        },
        update: async function(expense, id) {
            return await axios.put('/api/credit-card/transaction/' + id, expense)
        },
        delete: async function(id) {
            return await axios.delete('/api/credit-card/transaction/' + id)
        }
    },
    movement: {
        indexFiltered: async function(filter) {
            const request = await axios.get('/api/movement/filter/' + filter)
            return request.data
        },
        delete: async function(id) {
            return await axios.delete('/api/movement/' + id)
        },
        show: async function(id) {
            const request = await axios.get('/api/movement/' + id)
            return request.data
        },
        insert: async function(movement) {
            return await axios.post('/api/movement', movement)
        },
        update: async function(movement, id) {
            return await axios.put('/api/movement/' + id, movement)
        }
    },
    userActions: {
        logout: async function() {
            RequestTools.storage.removeItens()
            localStorage.removeItem('salutation')
            return await axios.get('/logout')
        }
    },
    futureGain: {
        getNextSixMonthsGains: async function() {
            const request = await axios.get('/api/future-gain/next-six-months')
            return request.data
        },
        delete: async function(id) {
            return await axios.delete('/api/future-gain/' + id)
        },
        receive: async function(id) {
            return await axios.post('/api/future-gain/' + id + '/receive')
        },
        show: async function(id) {
            const request = await axios.get('/api/future-gain/' + id)
            return request.data
        },
        insert: async function(futureGain) {
            return await axios.post('/api/future-gain', futureGain)
        },
        update: async function(futureGain, id) {
            return await axios.put('/api/future-gain/' + id, futureGain)
        }
    },
    futureSpent: {
        delete: async function(id) {
            return await axios.delete('/api/future-spent/' + id)
        },
        pay: async function(id) {
            return await axios.post('/api/future-spent/' + id + '/pay')
        },
        show: async function(id) {
            const request = await axios.get('/api/future-spent/' + id)
            return request.data
        },
        insert: async function(futureSpent) {
            return await axios.post('/api/future-spent', futureSpent)
        },
        update: async function(futureSpent, id) {
            return await axios.put('/api/future-spent/' + id, futureSpent)
        }
    },
    dashboard: {
        index: async function() {
            const request = await axios.get('/api/dashboard')
            return request.data
        }
    },
    configurations: {
        getSalary: async function() {
            const request = await axios.get('/api/configurations/salary')
            return request.data
        },
        update: async function(config, data) {
            return await axios.put('/api/configurations/' + config, data)
        }
    },
    user: {
        show: async function(id) {
            const request = await axios.get('/api/user/' + id)
            return request.data
        },
        update: async function(id, user) {
            return await axios.put('/api/user/' + id, user)
        }
    },
    panorama: {
        index: async function() {
            const request = await axios.get('/api/panorama')
            return request.data
        }
    },
}

export default apiRouter