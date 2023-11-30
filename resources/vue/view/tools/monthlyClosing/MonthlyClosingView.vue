(<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Relatório fechamento de mês" />
                <filter-top-right :useTypeMovementFilter="false"
                                  :rangeDate="CalendarTools.getLastOneYearPeriod()"
                                  @filter-quest="getMonthlyClosingsIndexFiltered($event)" />
                <back-button to="/ferramentas" class="top-button"/>
            </div>
            <divider/>
            <div class="glass chart-div mb-4">
                <div class="ms-5 me-5">
                    <line-chart :options="chartOptions" :data="chartData" />
                </div>
            </div>
            <div class="card glass success balance-card">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr class="text-center border-table">
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
                                <tbody class="table-body-hover">
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
                        </div>
                    </div>
                </div>
            </div>
            <divider/>
        </div>
    </div>
</template>

<script>
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import iconEnum from '~js/enums/iconEnum.js'
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import BackButton from '~vue-component/buttons/BackButton.vue'
import apiRouter from '~js/router/apiRouter.js'
import CalendarTools from '~js/tools/calendarTools.js'
import StringTools from '~js/tools/stringTools.js'
import FilterTopRight from '~vue-component/filters/filterTopRight.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import GainIcon from '~vue-component/icons/GainIcon.vue'
import SpentIcon from '~vue-component/icons/SpentIcon.vue'
import LineChart from '~vue-component/graphics/LineChart.vue'
import { monthlyClosingChartParams } from '~js/chartParams/monthlyClosingChartParams.js'

export default {
    name: 'MonthlyClosingView',
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
            monthlyClosings: {
                createdAt: '',
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
        async getMonthlyClosingsIndexFiltered(quest) {
            this.loadingDone = false
            await apiRouter.monthlyClosing.indexFiltered(quest).then(response => {
                this.monthlyClosings = response.data
                this.chartData = response.chartData
            })
            this.loadingDone = true
        }
    },
    async mounted() {
        const lastOneYearPeriod = CalendarTools.getLastOneYearPeriod()
        const quest = `?dateStart=${lastOneYearPeriod[0]}&dateEnd=${lastOneYearPeriod[0]}`
        await this.getMonthlyClosingsIndexFiltered(quest)
    }
}
</script>

<style scoped lang="scss">
    @import "../../../../sass/variables";
    .chart-div{
        width: 100%;
    }
    .border-table {
        border-bottom: 2px solid $table-line-divider-color;
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
        .chart-div {
            display: none;
        }
    }
</style>