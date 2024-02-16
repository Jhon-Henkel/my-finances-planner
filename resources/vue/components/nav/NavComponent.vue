<template>
    <div class="nav mt-2 justify-content-end">
        <slot/>
    </div>
</template>

<script>
export default {
    name: "MfpNavComponent"
}
</script>

<style scoped lang="scss">
@media (max-width: 1000px) {
    .nav {
        flex-direction: column;
    }
}
</style>