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
    .action-buttons {
        display: flex;
        justify-content: center;
    }
    .base-container {
        margin-top: 60px;
    }
    .base-container hr {
        height: 8px;
        border: 0;
        border-radius: 15px 15px 15px 15px;
        box-shadow: 0 0 0.5em #000000;
        background-color: #04fac9;
    }
    .btn-success {
        background: #096452;
        color: #ffffff;
        box-shadow: 0 0 0.4em #000000;
        border: 0;
    }
    .btn-success:hover {
        background: #09836b;
        box-shadow: 0 0.5em 0.5em -0.4em #000000;
        transform: translateY(-0.25em);
        transition-duration: 300ms;
    }
    .btn-success:focus {
        border: 0;
        box-shadow: 0 0 0.2rem #000000
    }
    .btn-danger {
        background: #c21111;
        color: #ffffff;
        box-shadow: 0 0 0.4em #000000;
        border: 0;
    }
    .btn-danger:hover {
        background: #dc1313;
        box-shadow: 0 0.5em 0.5em -0.4em #000000;
        transform: translateY(-0.25em);
        transition-duration: 300ms;
    }
    .btn-danger:focus {
        border: 0;
        box-shadow: 0 0 0.2rem #000000
    }
    table tr:first-child th {
        border-bottom: 2px solid #096452;
    }
    .text-red {
        color: #c21111;
    }
</style>