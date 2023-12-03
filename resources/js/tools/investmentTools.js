import requestTools from './requestTools'
import externalApiRouter from '../router/externalApiRouter'
import CalendarTools from './calendarTools'

const InvestmentTools = {
    getBrasilTax: async function() {
        const itemStorage = requestTools.storage.getStorageItem('brasilTax')
        if (itemStorage) {
            return itemStorage
        }
        return await externalApiRouter.brasilApi.getTax().then((response) => {
            const item = { selic: 0, cdi: 0, ipca: 0 }
            response.forEach((tax) => {
                if (tax.nome === 'Selic') {
                    item.selic = tax.valor
                } else if (tax.nome === 'CDI') {
                    item.cdi = tax.valor
                } else if (tax.nome === 'IPCA') {
                    item.ipca = tax.valor
                }
            })
            requestTools.storage.setStorageItem('brasilTax', item, CalendarTools.sixHoursInMs())
            return item
        })
    }
}

export default InvestmentTools