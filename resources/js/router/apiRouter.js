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
        }
    },
    userActions: {
        logout: async function() {
            return await axios.get('/logout')
        }
    }
}

export default apiRouter