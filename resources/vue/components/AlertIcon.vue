<template>
    <font-awesome-icon :icon="icon" :title="title" :class="classIcon" />
</template>

<script>
    import iconEnum from "../../js/enums/iconEnum";
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

    export default {
        name: "AlertIcon",
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
        },
    }
</script>

<style scoped lang="scss">
    @import "../../sass/variables";

    .icon-alert {
        color: $alert-icon-color;
    }
</style>