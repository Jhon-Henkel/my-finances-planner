<template>
    <hr class="divider mt-4 mb-4">
</template>

<script>
    export default {
        name: "Divider"
    }
</script>

<style lang="scss" scoped>
    @import "../../sass/variables";

    .divider{
        height: 8px;
        border: 0;
        border-radius: 15px 15px 15px 15px;
        box-shadow: 0 0 0.5em $black-color;
        background-color: $divider-component-color;
    }
</style>