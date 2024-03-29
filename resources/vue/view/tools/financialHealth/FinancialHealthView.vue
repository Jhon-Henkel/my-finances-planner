<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Saúde Financeira'"/>
                <filter-top-right :useTypeMovementFilter="false"
                                  :useRadioGroupCardExpenses="true"
                                  @filter-quest="getMovementIndexFiltered($event)" />
                <back-button to="/ferramentas" class="top-button"/>
            </div>
            <divider/>
            <div class="card glass balance-card ms-1">
                <div class="card-body text-center">
                    <h4 class="card-title">Gráficos categorizando movimentações do período</h4>
                    <hr>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-6">
                                <h5>
                                    <spent-icon class="me-2" />
                                    Gastos
                                </h5>
                                <hr>
                                <DoughnutChart :options="graphOptions" :data="spendingGraphData" />
                                <hr>
                                <h5>
                                    <spent-icon class="me-2" />
                                    Total gasto: {{ stringTools.formatFloatValueToBrString(totalSpent) }}
                                </h5>
                            </div>
                            <div class="col-6">
                                <h5>
                                    <gain-icon class="me-2" />
                                    Ganhos
                                </h5>
                                <hr>
                                <DoughnutChart :options="graphOptions" :data="gainsGraphData" />
                                <hr>
                                <h5>
                                    <gain-icon class="me-2" />
                                    Total ganho: {{ stringTools.formatFloatValueToBrString(totalGains) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card glass balance-card mt-4">
                <div class="card-body text-center">
                    <h4 class="cart-title">Lista de gastos e ganhos ordenados por maior valor</h4>
                    <hr>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-6">
                                <h5>
                                    <spent-icon class="me-2" />
                                    Gastos
                                </h5>
                                <hr>
                                <table class="table table-transparent table-borderless text-start">
                                    <thead>
                                        <tr>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(value, description) in movements[MovementEnum.type.spent()]">
                                            <td>{{ description }}</td>
                                            <td>{{ stringTools.formatFloatValueToBrString(value) }}</td>
                                            <td>{{ numberTools.getPercentageNumber(value, totalSpent) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <h5>
                                    <gain-icon class="me-2" />
                                    Ganhos
                                </h5>
                                <hr>
                                <table class="table table-transparent table-borderless text-start">
                                    <thead>
                                        <tr>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(value, description) in movements[MovementEnum.type.gain()]">
                                            <td>{{ description }}</td>
                                            <td>{{ stringTools.formatFloatValueToBrString(value) }}</td>
                                            <td>{{ numberTools.getPercentageNumber(value, totalGains) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <divider/>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import Divider from '~vue-component/DividerComponent.vue'
import apiRouter from '~js/router/apiRouter.js'
import MovementEnum from '~js/enums/movementEnum.js'
import DoughnutChart from '~vue-component/graphics/DoughnutChart.vue'
import stringTools from '~js/tools/stringTools.js'
import BackButton from '~vue-component/buttons/BackButton.vue'
import FilterTopRight from '~vue-component/filters/filterTopRight.vue'
import defaultChartParams from '~js/chartParams/defaultChartParams.js'
import SpentIcon from '~vue-component/icons/SpentIcon.vue'
import GainIcon from '~vue-component/icons/GainIcon.vue'
import numberTools from '~js/tools/numberTools.js'

const SPENT_ID = MovementEnum.type.spent()
const GAIN_ID = MovementEnum.type.gain()

export default {
    name: 'FinancialHealthView',
    computed: {
        numberTools() {
            return numberTools
        },
        MovementEnum() {
            return MovementEnum
        },
        stringTools() {
            return stringTools
        }
    },
    components: {
        GainIcon,
        SpentIcon,
        FilterTopRight,
        BackButton,
        DoughnutChart,
        Divider,
        MfpTitle,
        LoadingComponent
    },
    data() {
        return {
            loadingDone: false,
            lastFilter: null,
            movements: {},
            graphOptions: defaultChartParams.options('right'),
            spendingGraphData: defaultChartParams.data,
            gainsGraphData: defaultChartParams.data,
            totalGains: 0,
            totalSpent: 0
        }
    },
    methods: {
        async getMovementIndexFiltered(quest) {
            this.loadingDone = false
            await apiRouter.financialHealth.indexFiltered(quest).then((response) => {
                this.movements = response
                const spending = response.dataForGraph[SPENT_ID]
                const gains = response.dataForGraph[GAIN_ID]
                this.totalSpent = spending.total
                this.totalGains = gains.total
                this.spendingGraphData = {
                    labels: spending.label,
                    datasets: [
                        {
                            backgroundColor: spending.color,
                            borderColor: spending.color,
                            data: spending.data
                        }
                    ]
                }
                this.gainsGraphData = {
                    labels: gains.label,
                    datasets: [
                        {
                            backgroundColor: gains.color,
                            borderColor: gains.color,
                            data: gains.data
                        }
                    ]
                }
            })
            this.loadingDone = true
        }
    },
    async mounted() {
        await this.getMovementIndexFiltered()
    }
}
</script>

<style scoped lang="scss">
    @import "../../../../sass/variables";

    .card {
        width: 24rem;
    }
    .balance-card {
        width: 80.5rem;
    }
    @media (max-width: 1000px) {
        .nav {
            flex-direction: column;
        }
        .top-button {
            margin-top: 10px;
            border-radius: 8px !important;
        }
        .balance-card {
            width: 100%;
        }
        .card-text .row .col-6 {
            margin-bottom: 20px;
            width: 100%;
            font-size: 0.8rem;
        }
    }
</style>