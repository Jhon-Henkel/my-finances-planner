<template>
    <font-awesome-icon :icon="iconEnum.triangleExclamation()" :title="title" :class="classIcon" />
</template>

<script>
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