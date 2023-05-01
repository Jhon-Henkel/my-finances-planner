const MFP_TOKEN = 'mfp_token'

const RequestTools = {
    user: {
        getIdUserLogged: async function () {
            return parseInt(localStorage.getItem('userId'))
        }
    },
    storage: {
        removeItens: function () {
            localStorage.removeItem('userId')
            localStorage.removeItem('userSalary')
        }
    }
}

export default RequestTools;