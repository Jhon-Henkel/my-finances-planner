function formatValueToBr(imputId) {
    let element = document.getElementById(imputId);
    let value = element.value;
    value = this.onlyNumber(value)
    if (value.length > 2) {
        value = value.replace(/([0-9]{2})$/g, ",$1");
    }
    if (value.length > 6) {
        value = value.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    }
    element.value = value;
    if(value === 'NaN') element.value = '';
}

function onlyNumber(value) {
    value = value + ''
    value = parseInt(value.replace(/[\D]+/g, ''));
    value = value + ''
    return value
}