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
    },
    isApplicationInDemoMode: function () {
        if (import.meta.env.VITE_APP_DEMO_MODE === 'true') {
            return true
        }
        return false
    }
}

export default RequestTools;