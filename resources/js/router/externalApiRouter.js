import requestTools from '../tools/requestTools'

const externalApiRouter = {
    brasilApi: {
        getTax: async function() {
            const request = await requestTools.request.get('https://brasilapi.com.br/api/taxas/v1')
            return request.data
        }
    }
}

export default externalApiRouter