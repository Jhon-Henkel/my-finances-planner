import {format, setCursor, event} from './util'
import assign from './assign'
import defaults from './options'

export default function (element, binding) {
    if (!binding.value) return
    let opt = assign(defaults, binding.value)
    if (element.tagName.toLocaleUpperCase() !== 'INPUT') {
        let els = element.getElementsByTagName('input')
        if (els.length !== 1) {
        } else {
            element = els[0]
        }
    }
    element.oninput = function () {
        let positionFromEnd = element.value.length - element.selectionEnd
        element.value = format(element.value, opt)
        positionFromEnd = Math.max(positionFromEnd, opt.suffix.length)
        positionFromEnd = element.value.length - positionFromEnd
        positionFromEnd = Math.max(positionFromEnd, opt.prefix.length + 1)
        setCursor(element, positionFromEnd)
        element.dispatchEvent(event('change'))
    }
    element.onfocus = function () {
        setCursor(element, element.value.length - opt.suffix.length)
    }
    element.oninput()
    element.dispatchEvent(event('input'))
}