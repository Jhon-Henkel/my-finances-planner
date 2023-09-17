import { format, setCursor, event } from './util'
import assign from './assign'
import defaults from './options'

export default function(element, binding) {
    if (!binding.value) return
    const option = assign(defaults, binding.value)
    if (element.tagName.toLocaleUpperCase() !== 'INPUT') {
        const elements = element.getElementsByTagName('input')
        if (elements.length !== 1) {
        } else {
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
        element.dispatchEvent(event('change'))
    }
    element.onfocus = function() {
        setCursor(element, element.value.length - option.suffix.length)
    }
    element.oninput()
    element.dispatchEvent(event('input'))
}