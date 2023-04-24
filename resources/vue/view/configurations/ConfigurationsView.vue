<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <message :message="message" :type="messageType" v-show="message"/>
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Configurações'"/>
            </div>
            <divider/>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import Message from "../../components/MessageComponent.vue";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";

    export default {
        name: "ConfigurationsView",
        components: {
            MfpTitle,
            Divider,
            Message,
            LoadingComponent
        },
        data() {
            return {
                loadingDone: false,
                message: null,
                messageType: null,
            }
        },
    }
</script>

<style scoped>

</style>