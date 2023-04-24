const THIS_MONTH = 2;
const LAST_MONTH = 3;
const THIS_YEAR = 4;
const THIS_MONTH_LABEL = 'Este Mês';
const LAST_MONTH_LABEL = 'Último Mês';
const THIS_YEAR_LABEL = 'Este Ano';
const SPENT = 5;
const GAIN = 6;
const TRANSFER = 7;

const MovementEnum = {
    getFilterList: () => {
        return [
            { id: THIS_MONTH, label: THIS_MONTH_LABEL },
            { id: LAST_MONTH, label: LAST_MONTH_LABEL },
            { id: THIS_YEAR, label: THIS_YEAR_LABEL },
        ];
    },
    filter: {
        thisMonth: () => THIS_MONTH,
        lastMonth: () => LAST_MONTH,
        thisYear: () => THIS_YEAR,
    },
    getTypeList: () => {
        return [
            { id: GAIN, label: 'Receita' },
            { id: SPENT, label: 'Despesa' },
        ]
    },
    getLabelForType: function(type) {
        switch (type) {
            case SPENT:
                return 'Despesa';
            case GAIN:
                return 'Receita';
            case TRANSFER:
                return 'Transferência';
            default:
                return 'Desconhecido';
        }
    },
    type: {
        spent: () => SPENT,
        gain: () => GAIN,
        transfer: () => TRANSFER,
    }
};
export default MovementEnum;