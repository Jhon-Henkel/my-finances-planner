<template>
    <font-awesome-icon :icon="iconEnum.triangleExclamation()" :title="'Atenção, valor negativo!'" class="icon-alert" />
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
    }
</script>

<style scoped lang="scss">
    @import "../../sass/variables";

    .icon-alert {
        color: $alert-icon-color;
    }
</style>