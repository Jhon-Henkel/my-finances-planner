import { format, setCursor, event } from './util'
import assign from './assign'
import defaults from './options'

function moneyMask(element, binding) {
    if (!binding.value) return
    const option = assign(defaults, binding.value)
    if (element.tagName.toLocaleUpperCase() !== 'ION-INPUT') {
        const elements = element.getElementsByTagName('ion-input')
        if (elements.length === 1) {
            element = elements[0]
        }
    }
    element.oninput = function() {
        let positionFromEnd = element.value.length - element.selectionEnd
        element.value = format(element.value, option)
        positionFromEnd = Math.max(positionFromEnd, option.suffix.length)
        positionFromEnd = element.value.length - positionFromEnd
        positionFromEnd = Math.max(positionFromEnd, option.prefix.length + 1)
        setCursor(element, positionFromEnd)
        element.dispatchEvent(event('ionChange'))
    }
    element.onfocus = function() {
        setCursor(element, element.value.length - option.suffix.length)
    }
    element.oninput()
    element.dispatchEvent(event('ion-input'))
}

export default moneyMask