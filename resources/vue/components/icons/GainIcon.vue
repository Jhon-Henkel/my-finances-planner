<template>
    <font-awesome-icon :icon="iconEnum.circleArrowUp()" class="gain-icon" />
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import iconEnum from '../../../js/enums/iconEnum'

export default {
    name: 'GainIcon',
    computed: {
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        FontAwesomeIcon
    }
}
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .gain-icon {
        color: $success-icon-color;
    }
</style>