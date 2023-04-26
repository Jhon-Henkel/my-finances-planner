<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Dashboard'"/>
            </div>
            <divider/>
        </div>
    </div>
</template>

<script>
    import MfpTitle from "../../components/TitleComponent.vue";
    import Divider from "../../components/DividerComponent.vue";
    import LoadingComponent from "../../components/LoadingComponent.vue";

    export default {
        name: "DashboardView",
        components: {
            LoadingComponent,
            Divider,
            MfpTitle
        },
        data() {
            return {
                loadingDone: false,
                message: null,
                messageType: null,
            }
        }
    }
</script>

<style scoped>

</style>