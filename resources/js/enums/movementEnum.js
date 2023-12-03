const THIS_MONTH = 2
const LAST_MONTH = 3
const THIS_YEAR = 4
const THIS_MONTH_LABEL = 'Este Mês'
const LAST_MONTH_LABEL = 'Último Mês'
const THIS_YEAR_LABEL = 'Este Ano'
const SPENT = 5
const GAIN = 6
const TRANSFER = 7
const INVESTMENT_CDB = 8
const ALL = 0

const MovementEnum = {
    getFilterList: () => {
        return [
            { id: THIS_MONTH, label: THIS_MONTH_LABEL },
            { id: LAST_MONTH, label: LAST_MONTH_LABEL },
            { id: THIS_YEAR, label: THIS_YEAR_LABEL }
        ]
    },
    filter: {
        thisMonth: () => THIS_MONTH,
        lastMonth: () => LAST_MONTH,
        thisYear: () => THIS_YEAR
    },
    getLabelForType: function(type) {
        switch (type) {
        case SPENT:
            return 'Despesa'
        case GAIN:
            return 'Receita'
        case TRANSFER:
            return 'Transferência'
        case ALL:
            return 'Todos'
        case INVESTMENT_CDB:
            return 'Investimento CDB'
        default:
            return 'Desconhecido'
        }
    },
    getTypeList: function() {
        return [
            { id: ALL, label: this.getLabelForType(ALL) },
            { id: SPENT, label: this.getLabelForType(SPENT) },
            { id: GAIN, label: this.getLabelForType(GAIN) },
            { id: TRANSFER, label: this.getLabelForType(TRANSFER) },
            { id: INVESTMENT_CDB, label: this.getLabelForType(INVESTMENT_CDB) }
        ]
    },
    getTypeListForForm: function() {
        return [
            { id: SPENT, label: this.getLabelForType(SPENT) },
            { id: GAIN, label: this.getLabelForType(GAIN) }
        ]
    },
    type: {
        spent: () => SPENT,
        gain: () => GAIN,
        transfer: () => TRANSFER,
        investmentCDB: () => INVESTMENT_CDB,
        all: () => ALL
    }
}
export default MovementEnum