<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Saúde Financeira'"/>
                <font-awesome-icon :icon="iconEnum.filterMoney()" class="me-2 mt-1 filter"/>
                <div class="form-group me-3">
                    <select class="form-select form-select-sm" @change="getMovementsByFilter($event)">
                        <option v-for="filter in filterList" :key="filter.id" :value="filter.id">
                            {{ filter.label }}
                        </option>
                    </select>
                </div>
                <router-link class="btn btn-success rounded-5" to="/ferramentas">
                    <font-awesome-icon :icon="iconEnum.back()" class="me-2"/>
                    Voltar
                </router-link>
            </div>
            <divider/>
            <div class="card glass success balance-card ms-1">
                <div class="card-body text-center">
                    <h4 class="card-title">Gráficos categorizando movimentações do período</h4>
                    <hr>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-6">
                                <h5>
                                    <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="me-2 spent-icon"/>
                                    Gastos
                                </h5>
                                <hr>
                                <DoughnutChart :options="graphOptions" :data="spendingGraphData" />
                                <hr>
                                <h5>
                                    <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="me-2 spent-icon"/>
                                    Total gasto: {{ stringTools.formatFloatValueToBrString(totalSpent) }}
                                </h5>
                            </div>
                            <div class="col-6">
                                <h5>
                                    <font-awesome-icon :icon="iconEnum.circleArrowUp()" class="me-2 gain-icon"/>
                                    Ganhos
                                </h5>
                                <hr>
                                <DoughnutChart :options="graphOptions" :data="gainsGraphData" />
                                <hr>
                                <h5>
                                    <font-awesome-icon :icon="iconEnum.circleArrowUp()" class="me-2 gain-icon"/>
                                    Total ganho: {{ stringTools.formatFloatValueToBrString(totalGains) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../../components/LoadingComponent.vue";
    import MfpTitle from "../../../components/TitleComponent.vue";
    import Divider from "../../../components/DividerComponent.vue";
    import iconEnum from "../../../../js/enums/iconEnum";
    import apiRouter from "../../../../js/router/apiRouter";
    import MovementEnum from "../../../../js/enums/movementEnum";
    import DoughnutChart from "../../../components/graphics/DoughnutChart.vue";
    import StringTools from "../../../../js/tools/stringTools";
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import stringTools from "../../../../js/tools/stringTools";

    const SPENT_ID = MovementEnum.type.spent()
    const GAIN_ID = MovementEnum.type.gain()

    export default {
        name: "FinancialHealthView",
        computed: {
            stringTools() {
                return stringTools
            },
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            FontAwesomeIcon,
            DoughnutChart,
            Divider,
            MfpTitle,
            LoadingComponent,
        },
        data() {
            return {
                loadingDone: false,
                lastFilter: null,
                filterList: {},
                movements: {},
                graphOptions: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += StringTools.formatFloatValueToBrString(context.parsed);
                                    }
                                    return label;
                                },
                            }
                        },
                    }
                },
                spendingGraphData: {
                    labels: [],
                    datasets: [
                        {
                            backgroundColor: [],
                            data: []
                        }
                    ]
                },
                gainsGraphData: {
                    labels: [],
                    datasets: [
                        {
                            backgroundColor: [],
                            data: []
                        }
                    ]
                },
                totalGains: 0,
                totalSpent: 0,
            }
        },
        methods: {
            async getMovementsByFilter(event) {
                let filterId = event.target.value
                this.lastFilter = filterId
                await this.getMovementIndexFiltered(filterId)
            },
            async getMovementIndexFiltered(filterId) {
                this.loadingDone = false
                await apiRouter.financialHealth.indexFiltered(filterId).then((response) => {
                    this.movements = response
                    let spending = response.dataForGraph[SPENT_ID]
                    let gains = response.dataForGraph[GAIN_ID]
                    this.totalSpent = spending.total
                    this.totalGains = gains.total
                    this.spendingGraphData = {
                        labels: spending.label,
                        datasets: [
                            {
                                backgroundColor: spending.color,
                                data: spending.data
                            }
                        ]
                    }
                    this.gainsGraphData = {
                        labels: gains.label,
                        datasets: [
                            {
                                backgroundColor: gains.color,
                                data: gains.data
                            }
                        ]
                    }
                })
                this.loadingDone = true
            },
        },
        async mounted() {
            this.filterList = MovementEnum.getFilterList()
            await this.getMovementIndexFiltered(MovementEnum.filter.thisMonth())
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../../sass/variables";

    .filter {
        font-size: 22px;
        color: $success-icon-color;
    }
    .card {
        width: 24rem;
    }
    .balance-card {
        width: 80.5rem;
    }
    .gain-icon {
        color: $success-icon-color;
    }
    .spent-icon {
        color: $danger-icon-color;
    }
</style>