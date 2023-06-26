<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Relatório fechamento de mês'"/>
                <font-awesome-icon :icon="iconEnum.filterMoney()" class="me-2 mt-1 filter"/>
                <!-- TODO criar componente -->
                <div class="form-group me-3">
                    <select class="form-select form-select-sm" @change="getMonthlyClosingsByFilter($event)">
                        <option v-for="filter in filterList" :key="filter.id" :value="filter.id">
                            {{ filter.label }}
                        </option>
                    </select>
                </div>
                <back-button to="/ferramentas"/>
            </div>
            <divider/>

            <!-- DESENVOLVER -->

        </div>
    </div>
</template>

<script>
    import Divider from "../../../components/DividerComponent.vue";
    import MfpTitle from "../../../components/TitleComponent.vue";
    import iconEnum from "../../../../js/enums/iconEnum";
    import LoadingComponent from "../../../components/LoadingComponent.vue";
    import BackButton from "../../../components/buttons/BackButton.vue";

    export default {
        name: "MonthlyClosingView",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {BackButton, LoadingComponent, MfpTitle, Divider},
        data() {
            return {
                // TODO alterar para false quando desenvolver
                loadingDone: true,
                // TODO criar enum para os filtros
                filterList: [],

            }
        },
        methods: {
            getMonthlyClosingsByFilter(event) {
                console.log('desenvolver método getMonthlyClosingsByFilter')
            }
        },
        mounted() {

        }
    }
</script>

<style scoped lang="scss">
    @import "../../../../sass/variables";

    .filter {
        font-size: 22px;
        color: $success-icon-color;
    }
</style>