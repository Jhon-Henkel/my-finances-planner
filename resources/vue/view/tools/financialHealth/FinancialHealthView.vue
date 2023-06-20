<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Saúde Financeira'"/>

                <!-- fazer filtro aqui -->

                <router-link class="btn btn-success rounded-5" to="/ferramentas">
                    <font-awesome-icon :icon="iconEnum.back()" class="me-2"/>
                    Voltar
                </router-link>
            </div>
            <divider/>

            <!-- CONTEÚDO -->

        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../../components/LoadingComponent.vue";
    import MfpTitle from "../../../components/TitleComponent.vue";
    import Divider from "../../../components/DividerComponent.vue";
    import iconEnum from "../../../../js/enums/iconEnum";

    export default {
        name: "FinancialHealthView",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            Divider,
            MfpTitle,
            LoadingComponent
        },
        data() {
            return {
                loadingDone: false,
            }
        }
    }
</script>

<style scoped lang="scss">

</style>