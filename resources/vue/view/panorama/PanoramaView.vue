<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === 0"/>
        <div v-show="loadingDone === 1">
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
                        <td colspan="11">Despesas</td>
                    </tr>
                    <tr class="text-center">
                        <th><font-awesome-icon :icon="iconEnum.calendarCheck()"/></th>
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
                    <td>{{ spent.nextInstallmentDay }}</td>
                    <td>{{ spent.name }}</td>
                    <td>{{ spent.countName }}</td>
                    <td>{{ formatValueToBr(spent.firstInstallment) }}</td>
                    <td>{{formatValueToBr(spent.secondInstallment) }}</td>
                    <td>{{ formatValueToBr(spent.thirdInstallment) }}</td>
                    <td>{{ formatValueToBr(spent.forthInstallment) }}</td>
                    <td>{{ formatValueToBr(spent.fifthInstallment) }}</td>
                    <td>{{ formatValueToBr(spent.sixthInstallment) }}</td>
                    <td v-if="spent.remainingInstallments === 0" v-tooltip="'Despesa Fixa'">Fixo</td>
                    <td v-else v-tooltip="formatValueToBr(spent.totalRemainingValue)">
                        {{ spent.remainingInstallments }}
                    </td>
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
                </tbody>
            </table>
            <div class="row ms-1 mt-4">
                <div class="card glass success balance-card">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            <font-awesome-icon :icon="iconEnum.movement()" class="me-2"/>
                            Resumo
                        </h4>
                        <div class="card-text">
                            <table class="table text-white table-borderless">
                                <thead>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <th scope="col" v-for="(month, index) in months" :key="index">
                                        {{ calendarTools.getMonthNameByNumber(month) }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center">
                                    <td><font-awesome-icon :icon="iconEnum.circleArrowDown()" class="spent-icon me-2"/></td>
                                    <td class="text-start">Gastos</td>
                                    <td>{{ formatValueToBr(totalSpending.firstInstallment) }}</td>
                                    <td>{{ formatValueToBr(totalSpending.secondInstallment) }}</td>
                                    <td>{{ formatValueToBr(totalSpending.thirdInstallment) }}</td>
                                    <td>{{ formatValueToBr(totalSpending.forthInstallment) }}</td>
                                    <td>{{ formatValueToBr(totalSpending.fifthInstallment) }}</td>
                                    <td>{{ formatValueToBr(totalSpending.sixthInstallment) }}</td>
                                </tr>
                                <tr class="text-center">
                                    <td><font-awesome-icon :icon="iconEnum.creditCard()" class="icon-alert me-2"/></td>
                                    <td class="text-start">Cartões</td>
                                    <td>{{ formatValueToBr(cardsInvoice.firstInstallment) }}</td>
                                    <td>{{ formatValueToBr(cardsInvoice.secondInstallment) }}</td>
                                    <td>{{ formatValueToBr(cardsInvoice.thirdInstallment) }}</td>
                                    <td>{{ formatValueToBr(cardsInvoice.forthInstallment) }}</td>
                                    <td>{{ formatValueToBr(cardsInvoice.fifthInstallment) }}</td>
                                    <td>{{ formatValueToBr(cardsInvoice.sixthInstallment) }}</td>
                                </tr>
                                <tr class="text-center">
                                    <td><font-awesome-icon :icon="iconEnum.circleArrowUp()" class="gain-icon me-2"/></td>
                                    <td class="text-start">Ganhos</td>
                                    <td>{{ formatValueToBr(totalFutureGain.firstInstallment) }}</td>
                                    <td>{{ formatValueToBr(totalFutureGain.secondInstallment) }}</td>
                                    <td>{{ formatValueToBr(totalFutureGain.thirdInstallment) }}</td>
                                    <td>{{ formatValueToBr(totalFutureGain.forthInstallment) }}</td>
                                    <td>{{ formatValueToBr(totalFutureGain.fifthInstallment) }}</td>
                                    <td>{{ formatValueToBr(totalFutureGain.sixthInstallment) }}</td>
                                </tr>
                                <tr class="text-center">
                                    <td><font-awesome-icon :icon="iconEnum.circleArrowRight()" class="remaining-icon me-2"/></td>
                                    <td class="text-start">Sobras</td>
                                    <td>{{ formatValueToBr(totalRemaining.firstInstallment) }}
                                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.firstInstallment < 0"/>
                                    </td>
                                    <td>
                                        {{ formatValueToBr(totalRemaining.secondInstallment) }}
                                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.secondInstallment < 0"/>
                                    </td>
                                    <td>
                                        {{ formatValueToBr(totalRemaining.thirdInstallment) }}
                                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.thirdInstallment < 0"/>
                                    </td>
                                    <td>
                                        {{ formatValueToBr(totalRemaining.forthInstallment) }}
                                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.forthInstallment < 0"/>
                                    </td>
                                    <td>
                                        {{ formatValueToBr(totalRemaining.fifthInstallment) }}
                                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.fifthInstallment < 0"/>
                                    </td>
                                    <td>
                                        {{ formatValueToBr(totalRemaining.sixthInstallment) }}
                                        <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalRemaining.sixthInstallment < 0"/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ms-1 mt-4">
                <div class="card glass success balance-card">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            <font-awesome-icon :icon="iconEnum.wallet()" class="me-2"/>
                            Previsão considerando valor em carteira
                        </h4>
                        <hr>
                        <div class="card-text">
                            <div class="row">
                                <div class="col-4">
                                    <h6>
                                        <font-awesome-icon :icon="iconEnum.wallet()" class="movement-gain-icon"/>
                                        Valor em carteira
                                    </h6>
                                </div>
                                <div class="col-4">
                                    <select v-model="monthRemaining" class="form-select-sm text-center">
                                        <option value="10" disabled>Selecione o mês</option>
                                        <option v-for="(month, index) in months" :key="index" :value="index">
                                            {{ calendarTools.getMonthNameByNumber(month) }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <h6>
                                        <font-awesome-icon :icon="iconEnum.invoice()"/>
                                        Total
                                    </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    {{ formatValueToBr(totalWalletsValue) }}
                                </div>
                                <div class="col-4">
                                    {{ formatValueToBr(getValueForTotalSum()) }}
                                </div>
                                <div class="col-4">
                                    {{ formatValueToBr(totalWalletsValue + getValueForTotalSum()) }}
                                    <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalWalletsValue + getValueForTotalSum() < 0"/>
                                </div>
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
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import ActionButtons from "../../components/ActionButtons.vue";
    import calendarTools from "../../../js/tools/calendarTools";
    import StringTools from "../../../js/tools/stringTools";
    import CalendarTools from "../../../js/tools/calendarTools";
    import ApiRouter from "../../../js/router/apiRouter";
    import MessageEnum from "../../../js/enums/messageEnum";
    import MfpMessage from "../../components/MessageAlert.vue";

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
            MfpMessage,
            ActionButtons,
            MfpTitle,
            Divider,
            LoadingComponent
        },
        data() {
            return {
                loadingDone: 0,
                months: [],
                alertIcon: iconEnum.triangleExclamation(),
                spent: {
                    totalRemainingValue: 0,
                    remainingInstallments: 0,
                    countName: '',
                    nextInstallmentDay: 0
                },
                response: {
                    futureExpenses: 0,
                    totalFutureExpenses: 0,
                    totalFutureGains: 0,
                    totalLeft: 0,
                    totalCreditCardExpenses: 0,
                    totalWalletValue: 0
                },
                totalSpending: {
                    firstInstallment: 0,
                    secondInstallment: 0,
                    thirdInstallment: 0,
                    forthInstallment: 0,
                    fifthInstallment: 0,
                    sixthInstallment: 0,
                },
                totalFutureGain: {
                    firstInstallment: 0,
                    secondInstallment: 0,
                    thirdInstallment: 0,
                    forthInstallment: 0,
                    fifthInstallment: 0,
                    sixthInstallment: 0,
                },
                totalRemaining: {
                    firstInstallment: 0,
                    secondInstallment: 0,
                    thirdInstallment: 0,
                    forthInstallment: 0,
                    fifthInstallment: 0,
                    sixthInstallment: 0
                },
                cardsInvoice: {
                    firstInstallment: 0,
                    secondInstallment: 0,
                    thirdInstallment: 0,
                    forthInstallment: 0,
                    fifthInstallment: 0,
                    sixthInstallment: 0
                },
                futureSpending: {},
                totalWalletsValue: 0,
                monthRemaining: 10
            }
        },
        methods: {
            async updateFutureSpendingList() {
                this.loadingDone = 0
                await ApiRouter.panorama.index().then(response => {
                    this.futureSpending = response.futureExpenses
                    this.totalSpending = response.totalFutureExpenses
                    this.totalFutureGain = response.totalFutureGains
                    this.totalRemaining = response.totalLeft
                    this.cardsInvoice = response.totalCreditCardExpenses
                    this.totalWalletsValue = response.totalWalletValue
                    this.loadingDone = this.loadingDone + 1
                }).catch(() => {
                    this.messageError('Não foi possível carregar o panorama!')
                })
            },
            async deleteSpent(id, spentName) {
                if(confirm("Tem certeza que realmente quer deletar a despesa " + spentName + '?')) {
                    await ApiRouter.futureSpent.delete(id).then(response => {
                        this.messageSuccess('Despesa deletada com sucesso!')
                        this.updateFutureSpendingList()
                    }).catch(() => {
                        this.messageError('Não foi possível deletar a despesa!')
                    })
                }
            },
            async paySpent(id, spentName) {
                if(confirm("Você confirma o pagamento da despesa " + spentName + '?')) {
                    await ApiRouter.futureSpent.pay(id).then(response => {
                        this.messageSuccess('Despesa paga com sucesso!')
                        this.updateFutureSpendingList()
                    }).catch(() => {
                        this.messageError('Não foi possível pagar a despesa!')
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
                if (this.monthRemaining === 10) {
                    return 0
                } else if (this.monthRemaining === 0) {
                    return this.totalRemaining.firstInstallment
                } else if (this.monthRemaining === 1) {
                    return this.totalRemaining.secondInstallment
                } else if (this.monthRemaining === 2) {
                    return this.totalRemaining.thirdInstallment
                } else if (this.monthRemaining === 3) {
                    return this.totalRemaining.forthInstallment
                } else if (this.monthRemaining === 4) {
                    return this.totalRemaining.fifthInstallment
                } else if (this.monthRemaining === 5) {
                    return this.totalRemaining.sixthInstallment
                }
            },
            formatValueToBr(value) {
                return StringTools.formatFloatValueToBrString(value)
            },
            messageError(message) {
                this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
            },
            messageSuccess(message) {
                this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
            },
            showMessage(type, message, header) {
                this.$refs.message.showAlert(type,message,header)
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
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../../sass/variables";

    .gain-icon {
        color: $success-icon-color;
    }
    .spent-icon {
        color: $danger-icon-color;
    }
    .remaining-icon {
        color: $info-icon-color;
    }
    .icon-alert {
        color: $alert-icon-color;
    }
    .card {
        width: 24rem;
    }
    .balance-card {
        width: 80.5rem;
    }
    .card-text {
        font-size: 1rem;
    }
</style>