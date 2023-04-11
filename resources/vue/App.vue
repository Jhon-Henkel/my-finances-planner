<template>
    <side-bar-component/>
    <router-view/>
</template>

<script>
    import SideBarComponent from "./components/SideBarComponent.vue";

    export default {
        name: 'App',
        components: {
            SideBarComponent
        }
    }
</script>

<style>
    #title {
        margin: auto auto auto 0;
    }
</style>