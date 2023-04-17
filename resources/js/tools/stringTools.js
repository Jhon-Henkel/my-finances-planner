const stringTools = {
    formatFloatValueToBrString(value) {
        return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })
    }
}
export default stringTools