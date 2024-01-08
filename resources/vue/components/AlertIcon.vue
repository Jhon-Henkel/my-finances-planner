<template>
    <span  v-tooltip="title" >
        <font-awesome-icon :icon="iconEnum.triangleExclamation()" :class="classIcon" />
    </span>
</template>

<script>
import iconEnum from '~js/enums/iconEnum'

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