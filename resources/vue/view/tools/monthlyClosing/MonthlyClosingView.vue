<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Relatório fechamento de mês'"/>
                <filter-top-right :filter="filterList" @callbackMethod="getMonthlyClosingsIndexFiltered($event)"/>
                <back-button to="/ferramentas"/>
            </div>
            <divider/>
            <div class="glass chart-div mb-4">
                <div class="ms-5 me-5">
                    <line-chart :options="chartOptions" :data="chartData" />
                </div>
            </div>
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr class="text-center">
                        <td>
                            <font-awesome-icon :icon="iconEnum.calendarCheck()" />
                            Data
                        </td>
                        <td>
                            <spent-icon/>
                            Gasto Previsto
                        </td>
                        <td>
                            <spent-icon/>
                            Gasto Real
                        </td>
                        <td>
                            <gain-icon/>
                            Ganho Previsto
                        </td>
                        <td>
                            <gain-icon/>
                            Ganho Real
                        </td>
                        <td>
                            <font-awesome-icon :icon="iconEnum.scaleBalanced()" />
                            Balanço
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" v-for="closing in monthlyClosings" :key="closing.id">
                        <td>{{ CalendarTools.convertDateDbToBr(closing.createdAt) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(closing.predictedExpenses) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(closing.realExpenses) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(closing.predictedEarnings) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(closing.realEarnings) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(closing.balance) }}</td>
                    </tr>
                </tbody>
            </table>
            <divider/>
        </div>
    </div>
</template>

<script>
    import Divider from "../../../components/DividerComponent.vue";
    import MfpTitle from "../../../components/TitleComponent.vue";
    import iconEnum from "../../../../js/enums/iconEnum";
    import LoadingComponent from "../../../components/LoadingComponent.vue";
    import BackButton from "../../../components/buttons/BackButton.vue";
    import MonthlyClosingEnum from "../../../../js/enums/MonthlyClosingEnum";
    import apiRouter from "../../../../js/router/apiRouter";
    import CalendarTools from "../../../../js/tools/calendarTools";
    import StringTools from "../../../../js/tools/stringTools";
    import FilterTopRight from "../../../components/filters/filterTopRight.vue";
    import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
    import GainIcon from "../../../components/icons/GainIcon.vue";
    import SpentIcon from "../../../components/icons/SpentIcon.vue";
    import LineChart from "../../../components/graphics/LineChart.vue";
    import { monthlyClosingChartParams } from "../../../../js/chartParams/monthlyClosingChartParams";

    export default {
        name: "MonthlyClosingView",
        computed: {
            StringTools() {
                return StringTools
            },
            CalendarTools() {
                return CalendarTools
            },
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            LineChart,
            SpentIcon,
            GainIcon,
            FontAwesomeIcon,
            FilterTopRight,
            BackButton,
            LoadingComponent,
            MfpTitle,
            Divider
        },
        data() {
            return {
                loadingDone: false,
                filterList: {},
                monthlyClosings: {
                    createdAt: "",
                    predictedExpenses: 0,
                    realExpenses: 0,
                    predictedEarnings: 0,
                    realEarnings: 0,
                    balance: 0
                },
                chartOptions: monthlyClosingChartParams.options,
                chartData: monthlyClosingChartParams.data
            }
        },
        methods: {
            async getMonthlyClosingsIndexFiltered(filterId) {
                this.loadingDone = false
                await apiRouter.monthlyClosing.indexFiltered(filterId).then(response => {
                    this.monthlyClosings = response.data
                    this.chartData = response.chartData
                })
                this.loadingDone = true
            }
        },
        async mounted() {
            this.filterList = MonthlyClosingEnum.getFilterList()
            await this.getMonthlyClosingsIndexFiltered(MonthlyClosingEnum.filter.thisYear())
        }
    }
</script>

<style scoped lang="scss">
    .chart-div{
        width: 100%;
    }
</style>