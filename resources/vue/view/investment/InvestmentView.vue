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
                            <bar-chart :graph-options="graphOptions" :chart-data="chartData" />
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card glass">
                        <div class="card-body text-center">

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

export default {
    name: 'InvestmentView',
    computed: {
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
            graphOptions: investmentChartParams.options,
            chartData: investmentChartParams.data,
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
            ]
        }
    },
    methods: {
        async getInvestmentsDataGraph() {
            await apiRouter.investments.dataGraph().then(response => {
                console.log(response)
                this.investments = response
                this.populateDataGraphInvestmentsPerType()
            }).catch(error => {
                this.messageData = messageTools.errorMessage(error.response.data.message)
            })
            this.loadingDone = true
        },
        populateDataGraphInvestmentsPerType() {
            this.chartData = {
                labels: [this.investments.cdb.label],
                datasets: [
                    {
                        label: [this.investments.cdb.label],
                        backgroundColor: '#1ead98',
                        data: [this.investments.cdb.value]
                    }
                ]
            }
        }
    },
    mounted() {
        this.investments = this.getInvestmentsDataGraph()
    }
}
</script>

<style scoped>
    .chart {
        display: inline-flex;
        width: 100%;
    }
    @media (max-width: 1000px) {
        .me-2 {
            margin-right: 0 !important;
        }
    }
</style>