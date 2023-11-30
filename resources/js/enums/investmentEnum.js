const CDB_ID = 1
const CDB_CREDIT_LIMIT_ID = 2

const CDB_LABEL = 'CDB'
const CDB_CREDIT_LIMIT_LABEL = 'CDB com Limite de Crédito'

const InvestmentEnum = {
    getFilterList: () => {
        return [
            { id: CDB_ID, label: CDB_LABEL },
            { id: CDB_CREDIT_LIMIT_ID, label: CDB_CREDIT_LIMIT_LABEL }
        ]
    },
    type: {
        cdb: () => CDB_ID,
        cdbCreditLimit: () => CDB_CREDIT_LIMIT_ID
    }
}

export default InvestmentEnum