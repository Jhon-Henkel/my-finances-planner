export default {
    updateTooltip(el, { value, modifiers }) {
        el.setAttribute("data-v-tooltip", value);
        if (modifiers.arrow) {
            el.style.setProperty("--v-tooltip-arrow-display", "inline");
        }
    },
    mounted(el, { value, dir, modifiers }) {
        el.classList.add("data-v-tooltip");
        dir.updateTooltip(el, { value, modifiers });
    },
    updated(el, { value, dir, modifiers }) {
        dir.updateTooltip(el, { value, modifiers });
    }
};