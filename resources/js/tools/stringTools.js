const stringTools = {
    formatFloatValueToBrString(value) {
        if (!value) {
            return '-'
        }
        return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })
    }
}
export default stringTools