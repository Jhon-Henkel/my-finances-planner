const MONEY_TYPE = 5
const BANK_COUNT_TYPE = 6
const MEAL_TICKET_TYPE = 8
const TRANSPORT_TICKET_TYPE = 9
const HEALTH_TICKET_TYPE = 10
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
            case HEALTH_TICKET_TYPE:
                return 'Vale Saúde'
            case OTHER_TYPE:
                return 'Outros'
            default:
                return 'Desconhecido'
        }
    },
    type: {
        moneyType: MONEY_TYPE,
        bankType: BANK_COUNT_TYPE,
        mealTicketType: MEAL_TICKET_TYPE,
        transportTicketType: TRANSPORT_TICKET_TYPE,
        healthTicketType: HEALTH_TICKET_TYPE,
        otherType: OTHER_TYPE
    },
    getIdAndDescriptionTypeList: function () {
        return [
            {
                id: MONEY_TYPE,
                description: 'Dinheiro'
            },
            {
                id: BANK_COUNT_TYPE,
                description: 'Conta Bancária'
            },
            {
                id: MEAL_TICKET_TYPE,
                description: 'Vale Alimentação'
            },
            {
                id: TRANSPORT_TICKET_TYPE,
                description: 'Vale Transporte'
            },
            {
                id: HEALTH_TICKET_TYPE,
                description: 'Vale Saúde'
            },
            {
                id: OTHER_TYPE,
                description: 'Outros'
            }
        ]
    }
}
export default walletEnum