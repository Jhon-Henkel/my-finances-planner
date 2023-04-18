const routerNonAuthenticated = {
    login: {
        makeLogin: async function(user) {
            return await axios.post('/make-login',  user)
        },
        isUserLogged: async function() {
            return await axios.get('/is-user-logged')
        }
    }
}

export default routerNonAuthenticated;