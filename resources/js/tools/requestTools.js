const MFP_TOKEN = 'mfp_token'

const RequestTools = {
    token: {
        getMfpToken: async function () {
            let token = localStorage.getItem(MFP_TOKEN)
            if (! token) {
                await axios.get('/get-mfp-token').then((response) => {
                    token = response.data.mfpToken
                    localStorage.setItem(MFP_TOKEN, token)
                }).catch(() => {
                    token = ''
                })
            }
            return token
        }
    },
    user: {
        getIdUserLogged: async function () {
            return parseInt(localStorage.getItem('userId'))
        }
    }
}

export default RequestTools;