const routerNonAuthenticated = {
    login: {
        makeLogin: async function(user) {
            return await axios.post('/make-login',  user)
        }
    }
}

export default routerNonAuthenticated;