// todo a forma de buscar o token deve ser diferente
window.axios.defaults.headers.common['mfp-token'] = await axios.get('/get-mfp-token').then((response) => {
    return response.data.mfpToken
}).catch(() => {
    return '';
})

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
        }
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
            payInvoice: async function(month, cardId) {
                return await axios.put('/api/credit-card/' + cardId + '/invoices/' + month)
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
        }
    },
    userActions: {
        logout: async function() {
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
        }
    }
}

export default apiRouter