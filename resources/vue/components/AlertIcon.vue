<template>
    <font-awesome-icon :icon="icon" :title="title" :class="classIcon" />
</template>

<script>
import { icon } from '@fortawesome/fontawesome-svg-core'
import iconEnum from '../../js/enums/iconEnum'

export default {
    name: 'AlertIcon',
    computed: {
        iconEnum() {
            return iconEnum
        }
    },
    data() {
        return {
            icon: iconEnum.triangleExclamation(),
            title: 'Atenção, valor negativo!',
            classIcon: 'icon-alert'
        }
    }
}
</script>

<style scoped lang="scss">
    @import "../../sass/variables";

    .icon-alert {
        color: $alert-icon-color;
    }
</style>