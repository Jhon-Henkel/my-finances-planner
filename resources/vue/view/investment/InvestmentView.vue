<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav nav-item mt-2 justify-content-end">
                <mfp-title title="Investimentos"/>
                <mfp-drop-down-button :buttons-array="buttonsNewData" :align-itens-center="false" class="me-2"/>
                <mfp-drop-down-button :buttons-array="buttonsManageData"
                                      dropdownTitle="Gerenciar"
                                      :dropdownIcon="iconEnum.buildingColumns()" />
            </div>
            <divider/>
            <div class="row ms-2 chart">
                <div class="col-4">
                    <div class="card glass">
                        <div class="card-body text-center">
                            <bar-chart :graph-options="investmentGraphOptions" :chart-data="investmentTypesChartData" />
                        </div>
                    </div>
                </div>
                <div class="col-4 mobile-class">
                    <div class="card glass full-height">
                        <div class="card-body text-center">
                            <h4 class="card-title">
                                <font-awesome-icon :icon="iconEnum.piggyBank()" class="me-2"/>
                                Total Investido
                            </h4>
                            <hr>
                            <p class="card-text">{{ totalInvested }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 mobile-class">
                    <div class="card glass full-height">
                        <div class="card-body text-center">
                            <h4 class="card-title">
                                <font-awesome-icon :icon="iconEnum.billTrendUp()" class="me-2"/>
                                Principais indices hoje
                            </h4>
                            <hr>
                            <p class="card-text">Selic {{ taxToday.selic }} % ao ano</p>
                            <p class="card-text">IPCA {{ taxToday.ipca }} % ao ano</p>
                            <p class="card-text">CDI {{ taxToday.cdi }} % ao ano</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ms-2 chart mt-2">
                <div class="col-7 mobile-class">
                    <div class="card glass">
                        <div class="card-body text-center">
                            <bar-chart :graph-options="investmentGraphOptions" :chart-data="investmentMovementsChartData" />
                        </div>
                    </div>
                </div>
            </div>
            <divider/>
        </div>
    </div>
</template>

<script>
import MfpMessage from '~vue-component/MessageAlert.vue'
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpDropDownButton from '~vue-component/buttons/DropDownButtonGroup.vue'
import Divider from '~vue-component/DividerComponent.vue'
import IconEnum from '~js/enums/iconEnum'
import investmentEnum from '~js/enums/investmentEnum'
import apiRouter from '~js/router/apiRouter'
import messageTools from '~js/tools/messageTools'
import BarChart from '~vue-component/graphics/BarChart.vue'
import investmentChartParams from '~js/chartParams/investmentChartParams'
import StringTools from '~js/tools/stringTools'
import InvestmentTools from '~js/tools/investmentTools'

export default {
    name: 'InvestmentView',
    computed: {
        StringTools() {
            return StringTools
        },
        iconEnum() {
            return IconEnum
        },
        investmentEnum() {
            return investmentEnum
        }
    },
    components: {
        BarChart,
        Divider,
        MfpDropDownButton,
        MfpTitle,
        LoadingComponent,
        MfpMessage
    },
    data() {
        return {
            messageData: {},
            loadingDone: true,
            investments: [],
            contributedAndRescued: [
                {
                    labels: [],
                    contributed: [],
                    rescued: []
                }
            ],
            investmentGraphOptions: investmentChartParams.options,
            investmentMovementsGraphOptions: investmentChartParams.options,
            investmentTypesChartData: investmentChartParams.data,
            investmentMovementsChartData: investmentChartParams.data,
            buttonsNewData: [
                {
                    title: 'Novo CDB',
                    icon: IconEnum.billTrendUp(),
                    redirectTo: '/investimentos/cdb/cadastrar'
                }
            ],
            buttonsManageData: [
                {
                    title: 'Gerenciar CDB',
                    icon: IconEnum.billTrendUp(),
                    redirectTo: '/investimentos/cdb'
                }
            ],
            response: {
                contributedAndRescued: []
            },
            totalInvested: 0,
            taxToday: {
                cdi: 0,
                selic: 0,
                ipca: 0
            }
        }
    },
    methods: {
        async getInvestmentsDataGraph() {
            await apiRouter.investments.dataGraph().then(response => {
                this.investments = response
                this.contributedAndRescued = response.contributedAndRescued
                this.populateDataGraphInvestmentsPerType()
                this.populateDataGraphContributedAndRescued()
                this.totalInvested = StringTools.formatFloatValueToBrString(response.cdb.value)
            }).catch(error => {
                this.messageData = messageTools.errorMessage(error.response.data.message)
            })
            this.loadingDone = true
        },
        populateDataGraphInvestmentsPerType() {
            this.investmentTypesChartData = {
                labels: [this.investments.cdb.label],
                datasets: [
                    {
                        label: [this.investments.cdb.label],
                        backgroundColor: '#1ead98',
                        data: [this.investments.cdb.value]
                    }
                ]
            }
        },
        populateDataGraphContributedAndRescued() {
            this.investmentMovementsGraphOptions.plugins.title.text = 'Aportes e Resgates'
            this.investmentMovementsChartData = {
                labels: this.contributedAndRescued.labels,
                datasets: [
                    {
                        label: 'Contribuições',
                        backgroundColor: '#1ead98',
                        data: this.contributedAndRescued.contributed
                    },
                    {
                        label: 'Resgates',
                        backgroundColor: '#ff0000',
                        data: this.contributedAndRescued.rescued
                    }
                ]
            }
        },
        async getTaxToday() {
            await InvestmentTools.getBrasilTax().then(response => {
                this.taxToday = response
            })
        }
    },
    mounted() {
        this.investments = this.getInvestmentsDataGraph()
        this.getTaxToday()
    }
}
</script>

<style scoped>
    .chart {
        display: inline-flex;
        width: 100%;
    }
    .full-height {
        height: 100%;
    }
    @media (max-width: 1000px) {
        .me-2 {
            margin-right: 0 !important;
        }
        .mobile-class {
            width: 100%;
            margin-top: 25px;
        }
    }
</style>