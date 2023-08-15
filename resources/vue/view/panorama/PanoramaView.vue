<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone < 1"/>
        <div v-show="loadingDone === 1">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Panorama"/>
                <router-link class="btn btn-success rounded-5 top-button" to="/panorama/cadastrar-despesa">
                    <font-awesome-icon :icon="iconEnum.paying()" class="me-2"/>
                    Novo Gasto Futuro
                </router-link>
                <router-link class="btn btn-success rounded-5 ms-2 top-button" to="/panorama/todas-despesas-e-ganhos">
                    <font-awesome-icon :icon="iconEnum.movement()" class="me-2"/>
                    Ver todos Ganhos/Gastos
                </router-link>
            </div>
            <divider/>
            <div class="table-responsive-lg">
                <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <td colspan="11">Despesas</td>
                        </tr>
                        <tr class="text-center">
                            <th><font-awesome-icon :icon="iconEnum.calendarCheck()"/></th>
                            <th>Descrição</th>
                            <th scope="col" v-for="(month, index) in months" :key="index">
                                {{ calendarTools.getMonthNameByNumber(month) }}
                            </th>
                            <th>Restam</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-show="futureSpending.length === 0">
                            <td colspan="11">Nenhuma despesa cadastrada ainda!</td>
                        </tr>
                        <tr v-for="spent in futureSpending" :key="spent.id">
                            <td>{{ spent.nextInstallmentDay }}</td>
                            <td>{{ spent.name }}</td>
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
                                    @check-clicked="showPaySpentForm(
                                        spent.id,
                                        spent.countId,
                                        getNextSpentValue(spent),
                                        spent.name
                                    )"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <pay-receive :show-pay-receive="showPaySpent"
                         :value="paySpentValue"
                         :check-tooltip="'Pagar Despesa'"
                         :wallet-id="paySpentWalletId"
                         @hide-pay-receive="showPaySpent = false"
                         @pay="paySpent($event)"/>
            <div class="row ms-1 mt-4">
                <div class="card glass success balance-card">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            <font-awesome-icon :icon="iconEnum.movement()" class="me-2"/>
                            Resumo
                        </h4>
                        <div class="card-text">
                            <div class="table-responsive-lg">
                                <table class="table table-transparent table-borderless">
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
                                        <tr class="text-center text-nowrap">
                                            <td>
                                                <font-awesome-icon :icon="iconEnum.circleArrowDown()"
                                                                   class="spent-icon me-2"/>
                                            </td>
                                            <td class="text-start">Gastos</td>
                                            <td>{{ formatValueToBr(totalSpending.firstInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalSpending.secondInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalSpending.thirdInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalSpending.forthInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalSpending.fifthInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalSpending.sixthInstallment) }}</td>
                                        </tr>
                                        <tr class="text-center text-nowrap">
                                            <td>
                                                <font-awesome-icon :icon="iconEnum.creditCard()"
                                                                   class="card-icon me-2"/>
                                            </td>
                                            <td class="text-start">
                                                Cartões
                                                <a href="/gerenciar-cartoes" class="a-default" target="_blank">
                                                    <font-awesome-icon :icon="iconEnum.linkOut()" class="icon-out"/>
                                                </a>
                                            </td>
                                            <td>{{ formatValueToBr(cardsInvoice.firstInstallment) }}</td>
                                            <td>{{ formatValueToBr(cardsInvoice.secondInstallment) }}</td>
                                            <td>{{ formatValueToBr(cardsInvoice.thirdInstallment) }}</td>
                                            <td>{{ formatValueToBr(cardsInvoice.forthInstallment) }}</td>
                                            <td>{{ formatValueToBr(cardsInvoice.fifthInstallment) }}</td>
                                            <td>{{ formatValueToBr(cardsInvoice.sixthInstallment) }}</td>
                                        </tr>
                                        <tr class="text-center text-nowrap">
                                            <td>
                                                <font-awesome-icon :icon="iconEnum.circleArrowUp()"
                                                                   class="gain-icon me-2"/>
                                            </td>
                                            <td class="text-start">
                                                Ganhos
                                                <a href="/ganhos-futuros" class="a-default" target="_blank">
                                                    <font-awesome-icon :icon="iconEnum.linkOut()" class="icon-out"/>
                                                </a>
                                            </td>
                                            <td>{{ formatValueToBr(totalFutureGain.firstInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalFutureGain.secondInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalFutureGain.thirdInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalFutureGain.forthInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalFutureGain.fifthInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalFutureGain.sixthInstallment) }}</td>
                                        </tr>
                                        <tr class="text-center text-nowrap">
                                            <td><font-awesome-icon :icon="iconEnum.circleArrowRight()"
                                                                   class="remaining-icon me-2"/>
                                            </td>
                                            <td class="text-start">Sobras</td>
                                            <td>{{ formatValueToBr(totalRemaining.firstInstallment) }}
                                                <alert-icon v-if="totalRemaining.firstInstallment < 0"/>
                                            </td>
                                            <td>
                                                {{ formatValueToBr(totalRemaining.secondInstallment) }}
                                                <alert-icon v-if="totalRemaining.secondInstallment < 0"/>
                                            </td>
                                            <td>
                                                {{ formatValueToBr(totalRemaining.thirdInstallment) }}
                                                <alert-icon v-if="totalRemaining.thirdInstallment < 0"/>
                                            </td>
                                            <td>
                                                {{ formatValueToBr(totalRemaining.forthInstallment) }}
                                                <alert-icon v-if="totalRemaining.forthInstallment < 0"/>
                                            </td>
                                            <td>
                                                {{ formatValueToBr(totalRemaining.fifthInstallment) }}
                                                <alert-icon v-if="totalRemaining.fifthInstallment < 0"/>
                                            </td>
                                            <td>
                                                {{ formatValueToBr(totalRemaining.sixthInstallment) }}
                                                <alert-icon v-if="totalRemaining.sixthInstallment < 0"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                        <div class="card-text balance-content">
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
                                <div class="col-4 balance-value">
                                    {{ formatValueToBr(totalWalletsValue) }}
                                </div>
                                <div class="col-4 select-balance-value">
                                    {{ formatValueToBr(getValueForTotalSum()) }}
                                </div>
                                <div class="col-4 balance-value">
                                    {{ formatValueToBr(totalWalletsValue + getValueForTotalSum()) }}
                                    <alert-icon v-if="totalWalletsValue + getValueForTotalSum() < 0"/>
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
    import PayReceive from "../../components/PayReceiveComponent.vue";
    import AlertIcon from "../../components/AlertIcon.vue";

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
            AlertIcon,
            PayReceive,
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
                spent: {
                    totalRemainingValue: 0,
                    remainingInstallments: 0,
                    countName: '',
                    nextInstallmentDay: 0,
                    countId: 0,
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
                monthRemaining: 10,
                paySpentValue: 0,
                paySpentId: 0,
                showPaySpent: false,
                paySpentName: '',
                paySpentWalletId: 0,
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
            showPaySpentForm(id, walletId, value, name) {
                this.paySpentId = id
                this.paySpentWalletId = walletId
                this.paySpentValue = value
                this.paySpentName = name
                this.showPaySpent = true
            },
            getNextSpentValue(spent) {
                if (spent.firstInstallment) {
                    return spent.firstInstallment
                } else if (spent.secondInstallment) {
                    return spent.secondInstallment
                } else if (spent.thirdInstallment) {
                    return spent.thirdInstallment
                } else if (spent.forthInstallment) {
                    return spent.forthInstallment
                } else if (spent.fifthInstallment) {
                    return spent.fifthInstallment
                } else if (spent.sixthInstallment) {
                    return spent.sixthInstallment
                }
            },
            async paySpent(event) {
                let partial = event.partial ? " de forma parcial" : ""
                let confirmMessage = 'Você confirma o pagamento da despesa '
                confirmMessage = confirmMessage + '"' + this.paySpentName + '"'
                confirmMessage = confirmMessage + partial
                confirmMessage = confirmMessage + ' no valor de ' + StringTools.formatFloatValueToBrString(event.value)
                if(confirm(confirmMessage + '?')) {
                    let object = {
                        walletId: event.walletId,
                        value: event.value,
                        partial: event.partial
                    }
                    await ApiRouter.futureSpent.pay(this.paySpentId, object).then(response => {
                        this.messageSuccess('Despesa paga com sucesso!')
                        this.updateFutureSpendingList()
                        this.showPaySpent = false
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
            this.months = CalendarTools.getNextSixMonths(this.thisMonth)
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
    .card-icon {
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
    .a-default:hover {
        color: $success-icon-color;
    }
    .icon-out {
        font-size: 10px;
    }
    @media (max-width: 1000px) {
        .nav {
            flex-direction: column;
        }
        .top-button {
            margin-top: 10px;
            border-radius: 8px !important;
        }
        .ms-2 {
            margin-left: 0 !important;
        }
        .icon-out {
            display: none;
        }
        .card-text {
            font-size: 0.8rem;
        }
        .balance-card {
            width: 97%;
        }
        .balance-content {
            display: table-row;
            width: 100%;
        }
        .balance-content .row {
            display: table-cell;
        }
        .balance-content h6 {
            font-size: 0.8rem;
        }
        .balance-content .col-4 .form-select-sm {
            margin-bottom: 10px;
            margin-top: 10px;
        }
        .balance-value {
            white-space: nowrap;
            overflow: hidden;
        }
        .select-balance-value {
            margin-bottom: 18px;
            margin-top: 18px;
        }
    }
</style>