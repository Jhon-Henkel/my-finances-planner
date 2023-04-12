const stringTools = {
    formatValueToBr(value) {
        value = value.toString()
        value = this.onlyNumber(value)
        if (value.length > 2) {
            value = value.replace(/([0-9]{2})$/g, ",$1");
        }
        if (value.length > 6) {
            value = value.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
        }
        if (value.length === 2) {
            value = value + ',00'
        }
        return 'R$ ' + value
    },
    onlyNumber(value) {
        value = value + ''
        value = parseInt(value.replace(/[\D]+/g, ''));
        value = value + ''
        return value
    }
}
export default stringTools