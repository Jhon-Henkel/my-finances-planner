<template>
    <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="spent-icon" />
</template>

<script>
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import iconEnum from "../../../js/enums/iconEnum";

    export default {
        name: "SpentIcon",
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

    .spent-icon {
        color: $danger-icon-color;
    }
</style>