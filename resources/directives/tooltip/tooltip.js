export default {
    updateTooltip(element, { value, modifiers }) {
        element.setAttribute('data-v-tooltip', value)
        if (modifiers.arrow) {
            element.style.setProperty('--v-tooltip-arrow-display', 'inline')
        }
    },
    mounted(element, { value, dir, modifiers }) {
        element.classList.add('data-v-tooltip')
        dir.updateTooltip(element, { value, modifiers })
    },
    updated(element, { value, dir, modifiers }) {
        dir.updateTooltip(element, { value, modifiers })
    }
}