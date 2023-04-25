<template>
    <div class="base-container">
        <message :message="message" :type="messageType" v-show="message"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Panorama'"/>
                <router-link class="btn btn-success rounded-5" to="/panorama/cadastrar-despesa">
                    <font-awesome-icon :icon="iconEnum.paying()" class="me-2"/>
                    Novo Gasto Futuro
                </router-link>
            </div>
            <divider/>
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                <tr class="text-center">
                    <th>Descrição</th>
                    <th>Carteira</th>
                    <th scope="col" v-for="(month, index) in months" :key="index">
                        {{ calendarTools.getMonthNameByNumber(month) }}
                    </th>
                    <th>Restam</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="spent in futureSpending" :key="spent.id" class="text-center">
                    <td>{{ spent.name }}</td>
                    <td>{{ spent.countName }}</td>
                    <td>{{ spent.firstInstallment ? formatValueToBr(spent.firstInstallment) : '-' }}</td>
                    <td>{{ spent.secondInstallment ? formatValueToBr(spent.secondInstallment) : '-' }}</td>
                    <td>{{ spent.thirdInstallment ? formatValueToBr(spent.thirdInstallment) : '-' }}</td>
                    <td>{{ spent.forthInstallment ? formatValueToBr(spent.forthInstallment) : '-' }}</td>
                    <td>{{ spent.fifthInstallment ? formatValueToBr(spent.fifthInstallment) : '-' }}</td>
                    <td>{{ spent.sixthInstallment ? formatValueToBr(spent.sixthInstallment) : '-' }}</td>
                    <td>{{ spent.remainingInstallments === 0 ? 'Fixo' : spent.remainingInstallments }}</td>
                    <td class="text-center">
                        <action-buttons
                            :delete-tooltip="'Deletar Despesa'"
                            :tooltip-edit="'Editar Despesa'"
                            :edit-to="'/panorama/' + spent.id + '/atualizar-despesa'"
                            :check-button="showCheckButton(spent)"
                            :check-tooltip="'Marcar próxima como pago'"
                            @delete-clicked="deleteSpent(spent.id, spent.name)"
                            @check-clicked="paySpent(spent.id, spent.name)"/>
                    </td>
                </tr>
                <tr class="text-center border-table-spent">
                    <td>
                        <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="spent-icon me-1"/>
                        Gastos
                    </td>
                    <td></td>
                    <td>{{ formatValueToBr(totalSpending.firstMonth) }}</td>
                    <td>{{ formatValueToBr(totalSpending.secondMonth) }}</td>
                    <td>{{ formatValueToBr(totalSpending.thirdMonth) }}</td>
                    <td>{{ formatValueToBr(totalSpending.forthMonth) }}</td>
                    <td>{{ formatValueToBr(totalSpending.fifthMonth) }}</td>
                    <td>{{ formatValueToBr(totalSpending.sixthMonth) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="text-center border-table-gain">
                    <td>
                        <font-awesome-icon :icon="iconEnum.circleArrowUp()" class="gain-icon me-1"/>
                        Ganhos
                    </td>
                    <td></td>
                    <td>{{ formatValueToBr(totalFutureGain.firstMonth) }}</td>
                    <td>{{ formatValueToBr(totalFutureGain.secondMonth) }}</td>
                    <td>{{ formatValueToBr(totalFutureGain.thirdMonth) }}</td>
                    <td>{{ formatValueToBr(totalFutureGain.forthMonth) }}</td>
                    <td>{{ formatValueToBr(totalFutureGain.fifthMonth) }}</td>
                    <td>{{ formatValueToBr(totalFutureGain.sixthMonth) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="text-center border-table-remaining">
                    <td>
                        <font-awesome-icon :icon="iconEnum.circleArrowRight()" class="remaining-icon me-1"/>
                        Sobras
                    </td>
                    <td></td>
                    <td>
                        {{ formatValueToBr(totalRemaining.firstMonth) }}
                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.firstMonth < 0"/>
                    </td>
                    <td>
                        {{ formatValueToBr(totalRemaining.secondMonth) }}
                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.secondMonth < 0"/>
                    </td>
                    <td>
                        {{ formatValueToBr(totalRemaining.thirdMonth) }}
                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.thirdMonth < 0"/>
                    </td>
                    <td>
                        {{ formatValueToBr(totalRemaining.forthMonth) }}
                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.forthMonth < 0"/>
                    </td>
                    <td>
                        {{ formatValueToBr(totalRemaining.fifthMonth) }}
                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.fifthMonth < 0"/>
                    </td>
                    <td>
                        {{ formatValueToBr(totalRemaining.sixthMonth) }}
                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.sixthMonth < 0"/>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            <divider/>
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr class="text-center">
                        <td>Total em carteira</td>
                        <td></td>
                        <td>
                            <select v-model="monthForCalc" class="form-select-sm text-center">
                                <option value="10" disabled>Selecione o mês</option>
                                <option v-for="(month, index) in months" :key="index" :value="index">
                                    {{ calendarTools.getMonthNameByNumber(month) }}
                                </option>
                            </select>
                        </td>
                        <td></td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td>{{ formatValueToBr(totalWalletsValue) }}</td>
                        <td>+</td>
                        <td>{{ getValueForTotalSum() }}</td>
                        <td>=</td>
                        <td>{{ formatValueToBr(totalWalletsValue + getValueForTotalSum()) }}</td>
                    </tr>
                </tbody>
            </table>
            <divider/>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import Divider from "../../components/DividerComponent.vue";
    import Message from "../../components/MessageComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import ActionButtons from "../../components/ActionButtons.vue";
    import calendarTools from "../../../js/tools/calendarTools";
    import StringTools from "../../../js/tools/stringTools";
    import CalendarTools from "../../../js/tools/calendarTools";
    import ApiRouter from "../../../js/router/apiRouter";
    import MessageEnum from "../../../js/enums/messageEnum";
    import NumberTools from "../../../js/tools/numberTools";

    export default {
        name: "PanoramaView",
        computed: {
            StringTools() {
                return StringTools
            },
            calendarTools() {
                return calendarTools
            },
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            ActionButtons,
            MfpTitle,
            Message,
            Divider,
            LoadingComponent
        },
        data() {
            return {
                loadingDone: false,
                message: null,
                messageType: null,
                months: [],
                alertIcon: iconEnum.triangleExclamation(),
                totalSpending: {
                    firstMonth: 0,
                    secondMonth: 0,
                    thirdMonth: 0,
                    forthMonth: 0,
                    fifthMonth: 0,
                    sixthMonth: 0,
                    total: 0
                },
                totalFutureGain: {
                    firstMonth: 0,
                    secondMonth: 0,
                    thirdMonth: 0,
                    forthMonth: 0,
                    fifthMonth: 0,
                    sixthMonth: 0,
                    total: 0
                },
                totalRemaining: {
                    firstMonth: 0,
                    secondMonth: 0,
                    thirdMonth: 0,
                    forthMonth: 0,
                    fifthMonth: 0,
                    sixthMonth: 0,
                    total: 0
                },
                futureSpending: {},
                messageTimeOut: CalendarTools.fiveSecondsTimeInMs(),
                totalWalletsValue: 0,
                monthForCalc: 10
            }
        },
        methods: {
            resetMessage() {
                setTimeout(() =>
                        [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            },
            async updateFutureSpendingList() {
                this.loadingDone = false
                await ApiRouter.futureSpent.getNextSixMonthsSpending().then(response => {
                    this.futureSpending = response
                    this.calculateTotalSpendingPerMonth()
                    this.calculateTotalGainPerMonth()
                }).catch(error => {
                    this.message = 'Não foi possível carregar os despesas futuras!'
                    this.messageType = MessageEnum.messageTypeError()
                    this.resetMessage()
                })
            },
            calculateTotalSpendingPerMonth() {
                let totalPerMonthCount = NumberTools.calculateTotalPerMonthInvoiceItem(this.futureSpending)
                this.totalSpending.firstMonth = totalPerMonthCount.firstMonth
                this.totalSpending.secondMonth = totalPerMonthCount.secondMonth
                this.totalSpending.thirdMonth = totalPerMonthCount.thirdMonth
                this.totalSpending.forthMonth = totalPerMonthCount.forthMonth
                this.totalSpending.fifthMonth = totalPerMonthCount.fifthMonth
                this.totalSpending.sixthMonth = totalPerMonthCount.sixthMonth
                this.totalSpending.total = totalPerMonthCount.total
            },
            async calculateTotalGainPerMonth() {
                await ApiRouter.futureGain.getNextSixMonthsGains().then(response => {
                    let totalPerMonthCount = NumberTools.calculateTotalPerMonthInvoiceItem(response)
                    this.totalFutureGain.firstMonth = totalPerMonthCount.firstMonth
                    this.totalFutureGain.secondMonth = totalPerMonthCount.secondMonth
                    this.totalFutureGain.thirdMonth = totalPerMonthCount.thirdMonth
                    this.totalFutureGain.forthMonth = totalPerMonthCount.forthMonth
                    this.totalFutureGain.fifthMonth = totalPerMonthCount.fifthMonth
                    this.totalFutureGain.sixthMonth = totalPerMonthCount.sixthMonth
                    this.totalFutureGain.total = totalPerMonthCount.total
                    this.calculateTotalRemainingPerMonth()
                })
            },
            calculateTotalRemainingPerMonth() {
                this.totalRemaining.firstMonth = this.totalFutureGain.firstMonth - this.totalSpending.firstMonth
                this.totalRemaining.secondMonth = this.totalFutureGain.secondMonth - this.totalSpending.secondMonth
                this.totalRemaining.thirdMonth = this.totalFutureGain.thirdMonth - this.totalSpending.thirdMonth
                this.totalRemaining.forthMonth = this.totalFutureGain.forthMonth - this.totalSpending.forthMonth
                this.totalRemaining.fifthMonth = this.totalFutureGain.fifthMonth - this.totalSpending.fifthMonth
                this.totalRemaining.sixthMonth = this.totalFutureGain.sixthMonth - this.totalSpending.sixthMonth
                this.totalRemaining.total = this.totalFutureGain.total - this.totalSpending.total
                this.loadingDone = true
            },
            async deleteSpent(id, spentName) {
                if(confirm("Tem certeza que realmente quer deletar a despesa " + spentName + '?')) {
                    await ApiRouter.futureSpent.delete(id).then(response => {
                        this.message = 'Despesa deletada com sucesso!'
                        this.messageType = MessageEnum.messageTypeSuccess()
                        this.resetMessage()
                        this.updateFutureSpendingList()
                    }).catch(error => {
                        this.message = 'Não foi possível deletar a despesa!'
                        this.messageType = MessageEnum.messageTypeError()
                        this.resetMessage()
                    })
                }
            },
            async paySpent(id, spentName) {
                if(confirm("Você confirma o pagamento da despesa " + spentName + '?')) {
                    await ApiRouter.futureSpent.pay(id).then(response => {
                        this.message = 'Despesa paga com sucesso!'
                        this.messageType = MessageEnum.messageTypeSuccess()
                        this.resetMessage()
                        this.updateFutureSpendingList()
                    }).catch(error => {
                        this.message = 'Não foi possível pagar a despesa!'
                        this.messageType = MessageEnum.messageTypeError()
                        this.resetMessage()
                    })
                }
            },
            showCheckButton(spent) {
                if (
                    ! spent.firstInstallment
                    && ! spent.secondInstallment
                    && ! spent.thirdInstallment
                    && ! spent.forthInstallment
                    && ! spent.fifthInstallment
                    && ! spent.sixthInstallment
                ) {
                    return false
                }
                return true
            },
            getValueForTotalSum() {
                if (this.monthForCalc === 10) {
                    return 0
                } else if (this.monthForCalc === 0) {
                    return this.totalRemaining.firstMonth
                } else if (this.monthForCalc === 1) {
                    return this.totalRemaining.secondMonth
                } else if (this.monthForCalc === 2) {
                    return this.totalRemaining.thirdMonth
                } else if (this.monthForCalc === 3) {
                    return this.totalRemaining.forthMonth
                } else if (this.monthForCalc === 4) {
                    return this.totalRemaining.fifthMonth
                } else if (this.monthForCalc === 5) {
                    return this.totalRemaining.sixthMonth
                }
            },
            formatValueToBr(value) {
                return StringTools.formatFloatValueToBrString(value)
            }
        },
        async mounted() {
            this.thisMonth = CalendarTools.getThisMonth()
            this.months = [
                this.thisMonth,
                this.thisMonth + 1,
                this.thisMonth + 2,
                this.thisMonth + 3,
                this.thisMonth + 4,
                this.thisMonth + 5
            ]
            await this.updateFutureSpendingList()
            this.totalWalletsValue = await ApiRouter.wallet.getTotalWalletsValue()
        }
    }
</script>

<style scoped>
    .border-table-spent {
        border-top: 3px solid #096452;
        border-bottom: 1px solid #ff0000;
    }
    .border-table-gain {
        border-bottom: 1px solid #12c4a1;
    }
    .border-table-remaining {
        border-bottom: 1px solid #4a54ea;
    }
    .gain-icon {
        color: #12c4a1;
    }
    .spent-icon {
        color: #ff0000;
    }
    .remaining-icon {
        color: #4a54ea;
    }
    .icon-alert {
        color: #fdd200;
    }
</style>