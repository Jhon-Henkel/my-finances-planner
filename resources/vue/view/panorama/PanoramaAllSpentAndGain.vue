<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone < 2"/>
        <div v-show="loadingDone === 2">
            <div class="nav justify-content-end">
                <mfp-title title="Gerenciar despesas e ganhos"/>
                <router-link class="btn btn-success rounded-5" to="/panorama">
                    <font-awesome-icon :icon="iconEnum.back()" class="me-2"/>
                    Voltar
                </router-link>
            </div>
            <divider/>






        </div>
    </div>
</template>

<script>
    import MfpMessage from "../../components/MessageAlert.vue";
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import Divider from "../../components/DividerComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import ApiRouter from "../../../js/router/apiRouter";
    import MessageEnum from "../../../js/enums/messageEnum";

    export default {
        name: "PanoramaAllSpentAndGain",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            Divider,
            MfpTitle,
            LoadingComponent,
            MfpMessage
        },
        data() {
            return {
                loadingDone: 0,
                gains: {},
                spending: {},
            }
        },
        methods: {
            async getAllSpending() {
                await ApiRouter.futureSpent.index().then(response => {
                    this.spending = response
                }).catch(error => {
                    this.messageError(error.response.data.message)
                })
                this.loadingDone = this.loadingDone + 1
            },
            async getAllGains() {
                await ApiRouter.futureGain.index().then(response => {
                    this.gains = response
                }).catch(error => {
                    this.messageError(error.response.data.message)
                })
                this.loadingDone = this.loadingDone + 1
            },
            messageError(message) {
                this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
            },
            showMessage(type, message, header) {
                this.$refs.message.showAlert(type,message,header)
            }
        },
        async mounted() {
            await this.getAllSpending()
            await this.getAllGains()
            console.log(this.gains, this.spending)
        }
    }
</script>

<style scoped lang="scss">

</style>