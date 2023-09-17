const routerNonAuthenticated = {
    auth: {
        makeLogin: async function(user) {
            return await axios.post('/auth', user)
        },
        verify: async function(token) {
            return await axios.get('/auth/verify', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            })
        }
    }
}

export default routerNonAuthenticated