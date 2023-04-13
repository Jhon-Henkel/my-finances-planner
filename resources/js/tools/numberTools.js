const numberTools = {
    getSumTotalAmount: function (itens) {
        let sumTotalAmount = 0
        itens.forEach(item => {
            sumTotalAmount = sumTotalAmount + item.amount
        })
        return sumTotalAmount
    },
}
export default numberTools