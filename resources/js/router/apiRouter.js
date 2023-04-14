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
        // todo a responsabilidade de montar o data deve ser de quem está chamando o método e não do router
        insert: async function(wallet) {
            const data = {
                name: wallet.name,
                type: wallet.type,
                amount: wallet.amount
            }
            return await axios.post('/api/wallet', data)
        },
        // todo a responsabilidade de montar o data deve ser de quem está chamando o método e não do router
        update: async function(wallet) {
            const data = {
                name: wallet.name,
                type: wallet.type,
                amount: wallet.amount
            }
            return await axios.put('/api/wallet/' + wallet.id, data)
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