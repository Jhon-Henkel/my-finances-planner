// todo esse token não pode ser fixo
window.axios.defaults.headers.common['mfp-token'] = 'ae4f499431d5734df655751f419d8ce64242442e305a7f262bd1b7115a20c10c';

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
    userActions: {
        logout: async function() {
            return await axios.get('/logout')
        }
    }
}

export default apiRouter