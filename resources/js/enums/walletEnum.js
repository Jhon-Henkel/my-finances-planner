const MONEY_TYPE = 5
const BANK_COUNT_TYPE = 6
const MEAL_TICKET_TYPE = 8
const TRANSPORT_TICKET_TYPE = 9
const OTHER_TYPE = 0

const walletEnum = {
    getDescription: function (id) {
        switch (id) {
            case MONEY_TYPE:
                return  'Dinheiro'
            case BANK_COUNT_TYPE:
                return 'Conta Bancária'
            case MEAL_TICKET_TYPE:
                return 'Vale Alimentação'
            case TRANSPORT_TICKET_TYPE:
                return 'Vale Transporte'
            case OTHER_TYPE:
                return 'Outros'
            default:
                return 'Desconhecido'
        }
    }
}
export default walletEnum