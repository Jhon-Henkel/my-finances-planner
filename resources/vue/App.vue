<template>
    <nav-bar-component/>
    <side-bar-component/>
    <router-view/>
</template>

<script>
    import NavBarComponent from "./components/NavBarComponent.vue";
    import SideBarComponent from "./components/SideBarComponent.vue";

    export default {
        name: 'App',
        components: {
            SideBarComponent,
            NavBarComponent

        }
    }
</script>

<style scoped>

</style>