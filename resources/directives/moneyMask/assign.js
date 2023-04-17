export default function (defaults, extras) {
    defaults = defaults || {}
    extras = extras || {}
    return Object.keys(defaults).concat(Object.keys(extras)).reduce( function (acc, value) {
        acc[value] = extras[value] === undefined ? defaults[value] : extras[value]
        return acc
    }, {})
}