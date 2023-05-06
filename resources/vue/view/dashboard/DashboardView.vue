<template>
    <mfp-message ref="message"/>
    <div class="base-container">
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="salutation + ', é bom ter você aqui...'"/>
            </div>
            <divider/>
            <div class="row ms-2" style="display: inline-flex; width: 100%">
                <div class="col-4" v-for="data in cardData">
                    <div class="card glass" :class="data.type">
                        <div class="card-body text-center">
                            <h4 class="card-title">
                                <font-awesome-icon :icon="data.icon" class="me-2" :class="data.iconClass"/>
                                {{ data.title }}
                            </h4>
                            <hr>
                            <p class="card-text">
                                {{ StringTools.formatFloatValueToBrString(data.value) }}
                                <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="data.value < 0"/>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 ms-3">
                <div class="card glass me-5 success balance-card">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            <font-awesome-icon :icon="iconEnum.scaleBalanced()" class="me-2"/>
                            Balanço
                        </h4>
                        <hr>
                        <div class="card-text">
                            <div class="row">
                                <div class="col-4">
                                    <h6>Ultimo mês</h6>
                                </div>
                                <div class="col-4">
                                    <h6>Este mês</h6>
                                </div>
                                <div class="col-4">
                                    <h6>Este ano</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    {{ StringTools.formatFloatValueToBrString(balance.lastMonth) }}
                                    <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="balance.lastMonth < 0"/>
                                </div>
                                <div class="col-4">
                                    {{ StringTools.formatFloatValueToBrString(balance.thisMonth) }}
                                    <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="balance.thisMonth < 0"/>
                                </div>
                                <div class="col-4">
                                    {{ StringTools.formatFloatValueToBrString(balance.thisYear) }}
                                    <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="balance.thisYear < 0"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 ms-1">
                <div class="col-4">
                    <div class="card glass success">
                        <div class="card-body text-center">
                            <h4 class="card-title">
                                <font-awesome-icon :icon="iconEnum.sackDollar()" class="me-2"/>
                                Ultimas movimentações
                            </h4>
                            <hr>
                            <table class="table text-white">
                                <tbody>
                                    <tr v-for="movement in lastMovements">
                                        <td><font-awesome-icon :icon="movement.type" :class="movement.class"/></td>
                                        <td>{{ movement.date }}</td>
                                        <td>{{ movement.description }}</td>
                                        <td>{{ movement.value }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-8 glass success"  style="width: 63%">
                    <bar id="graph-movement" :options="graphOptions" :data="chartData"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MfpTitle from "../../components/TitleComponent.vue";
    import Divider from "../../components/DividerComponent.vue";
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import ApiRouter from "../../../js/router/apiRouter";
    import MfpMessage from "../../components/MessageAlert.vue";
    import MessageEnum from "../../../js/enums/messageEnum";
    import StringTools from "../../../js/tools/stringTools";
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import iconEnum from "../../../js/enums/iconEnum";
    import calendarTools from "../../../js/tools/calendarTools";
    import movementEnum from "../../../js/enums/movementEnum";
    import { Bar } from 'vue-chartjs'
    import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

    ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
    ChartJS.defaults.color = '#fff';

    export default {
        name: "DashboardView",
        computed: {
            iconEnum() {
                return iconEnum
            },
            StringTools() {
                return StringTools
            }
        },
        components: {
            FontAwesomeIcon,
            MfpMessage,
            LoadingComponent,
            Divider,
            MfpTitle,
            Bar
        },
        data() {
            return {
                alertIcon: iconEnum.triangleExclamation(),
                loadingDone: false,
                salutation: localStorage.getItem('salutation'),
                graphOptions: {
                    animation: {
                        y: {
                            easing: 'easeInQuad',
                            duration: 3000,
                            from: -100,
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            ticks: {
                                callback: value => StringTools.formatFloatValueToBrString(value)
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Movimentações por mês'
                        },
                        legend: {
                            display: true,
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += StringTools.formatFloatValueToBrString(context.parsed.y);
                                    }
                                    return label;
                                },
                            }
                        },
                    }
                },
                chartData: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Gastos',
                            backgroundColor: '#f87979',
                            data: [0,0,0,0,0,0,0,0,0,0,0,0],
                        },
                        {
                            label: 'Ganhos',
                            backgroundColor: '#79f879',
                            data: [0,0,0,0,0,0,0,0,0,0,0,0],
                        }
                    ]
                },
                data: {
                    walletBalance: 0,
                    movements: {
                        thisMonthSpent: 0,
                        thisMonthGain: 0,
                        lastMonthSpent: 0,
                        lastMonthGain: 0,
                        thisYearSpent: 0,
                        thisYearGain: 0,
                        lastMovements: [
                            {
                                createdAt: '',
                                walletName: '',
                            }
                        ],
                        dataForGraph: {
                            labels: [],
                            spentData: [],
                            gainData: []
                        }
                    },
                    futureSpent: {
                        thisMonth: 0,
                    },
                    futureGain: {
                        thisMonth: 0,
                    }
                },
                cardData: {
                    wallet: {
                        title: 'Total em carteira',
                        value: 0,
                        type: 'success',
                        icon: iconEnum.wallet(),
                        iconClass: ''
                    },
                    futureSpent: {
                        title: 'Pagar este mês',
                        value: 0,
                        type: 'warning',
                        icon: iconEnum.circleArrowDown(),
                        iconClass: 'spent-icon'
                    },
                    futureGain: {
                        title: 'Receber este mês',
                        value: 0,
                        type: 'success',
                        icon: iconEnum.circleArrowUp(),
                        iconClass: 'gain-icon'
                    },
                },
                balance: {
                    thisMonth: 0,
                    lastMonth: 0,
                    thisYear: 0,
                },
                lastMovements: [],
            }
        },
        methods: {
            populateData() {
                this.cardData.wallet.value = this.data.walletBalance;
                this.cardData.wallet.type = this.data.walletBalance < 0 ? 'warning' : 'success'
                this.cardData.futureSpent.value = this.data.futureSpent.thisMonth + this.data.creditCards.thisMonth
                this.cardData.futureGain.value = this.data.futureGain.thisMonth;
                this.balance.thisMonth = this.data.movements.thisMonthGain - this.data.movements.thisMonthSpent
                this.balance.lastMonth = this.data.movements.lastMonthGain - this.data.movements.lastMonthSpent
                this.balance.thisYear = this.data.movements.thisYearGain - this.data.movements.thisYearSpent
                this.data.movements.lastMovements.forEach(movement => {
                    this.lastMovements.push({
                        date: calendarTools.convertDateDbToBr(movement.createdAt).slice(0, 5),
                        type: movement.type === movementEnum.type.gain() ? iconEnum.circleArrowUp() : iconEnum.circleArrowDown(),
                        description: movement.walletName,
                        value: StringTools.formatFloatValueToBrString(movement.amount),
                        class: movement.type === movementEnum.type.gain() ? 'gain-icon' : 'spent-icon',
                    })
                })
            }
        },
        async mounted() {
            await ApiRouter.dashboard.index().then(response => {
                this.data = response;
                this.populateData();
                this.chartData = {
                    labels: this.data.movements.dataForGraph.labels,
                    datasets: [
                        {
                            label: 'Ganhos',
                            backgroundColor: '#1ead98',
                            data: this.data.movements.dataForGraph.gainData
                        },
                        {
                            label: 'Gastos',
                            backgroundColor: '#dc3545',
                            data: this.data.movements.dataForGraph.spentData
                        },
                    ]
                }
                this.loadingDone = true;
            }).catch(error => {
                this.$refs.message.showAlert(
                    MessageEnum.alertTypeError(),
                    error.response.data.message,
                    'Ocorreu um erro!'
                )
            })
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../../sass/variables";

    .card {
        width: 24rem;
    }
    .balance-card {
        width: 78rem;
    }
    .card-text {
        font-size: 1.5rem;
    }
    .success {
        box-shadow: 0 0 1em $success-icon-color;
    }
    .warning {
        box-shadow: 0 0 1em $danger-icon-color;
    }
    .icon-alert {
        color: $alert-icon-color;
    }
    .spent-icon {
        color: $danger-icon-color;
    }
    .gain-icon {
        color: $success-icon-color;
    }
</style>