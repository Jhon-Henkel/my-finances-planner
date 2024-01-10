<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone < 1"/>
        <div v-show="loadingDone === 1">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Panorama"/>
                <router-link class="btn btn-success rounded-2 top-button" to="/panorama/cadastrar-despesa">
                    <font-awesome-icon :icon="iconEnum.paying()" class="me-2"/>
                    Novo Gasto Futuro
                </router-link>
            </div>
            <divider/>
            <div class="card glass success balance-card">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <td colspan="11">Despesas</td>
                                    </tr>
                                    <tr class="text-center border-table">
                                        <th><font-awesome-icon :icon="iconEnum.calendarCheck()"/></th>
                                        <th>Descrição</th>
                                        <th scope="col" v-for="(month, index) in months" :key="index">
                                            {{ CalendarTools.getMonthNameByNumber(month) }}
                                        </th>
                                        <th>Restam</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center table-body-hover">
                                    <tr v-show="futureSpending.length === 0">
                                        <td colspan="11">Nenhuma despesa cadastrada ainda!</td>
                                    </tr>
                                    <tr v-for="spent in futureSpending" :key="spent.id">
                                        <td>
                                            <mfp-expires-date-badge :installment="spent"/>
                                        </td>
                                        <td class="text-start">{{ spent.name }}</td>
                                        <td>{{ formatValueToBr(spent.firstInstallment) }}</td>
                                        <td>{{ formatValueToBr(spent.secondInstallment) }}</td>
                                        <td>{{ formatValueToBr(spent.thirdInstallment) }}</td>
                                        <td>{{ formatValueToBr(spent.fourthInstallment) }}</td>
                                        <td>{{ formatValueToBr(spent.fifthInstallment) }}</td>
                                        <td>{{ formatValueToBr(spent.sixthInstallment) }}</td>
                                        <td v-if="spent.remainingInstallments === 0" v-tooltip="'Despesa Fixa'">Fixo</td>
                                        <td v-else v-tooltip="formatValueToBr(spent.totalRemainingValue)">
                                            {{ spent.remainingInstallments }}
                                        </td>
                                        <td class="text-center">
                                            <action-buttons
                                                v-if="mustShowActionButtons(spent)"
                                                delete-tooltip="Deletar Despesa"
                                                tooltip-edit="Editar Despesa"
                                                :edit-to="'/panorama/' + spent.id + '/atualizar-despesa'"
                                                :check-button="showCheckButton(spent)"
                                                check-tooltip="Marcar próxima como pago"
                                                @delete-clicked="deleteSpent(spent.id, spent.name)"
                                                @check-clicked="showPaySpentForm(
                                                    spent.id,
                                                    spent.countId,
                                                    getNextSpentValue(spent),
                                                    spent.name
                                                )"
                                            />
                                            <span class="badge text-bg-warning" v-tooltip="'Apenas informativo'" v-else>
                                                Informativo
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="text-center border-table-top">
                                        <td colspan="10" class="no-hover">
                                            <router-link class="a-default" to="/panorama/todas-despesas-e-ganhos">
                                                Gerenciar Registros
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <pay-receive :show-pay-receive="showPaySpent"
                         :value="paySpentValue"
                         :check-tooltip="'Pagar Despesa'"
                         :wallet-id="paySpentWalletId"
                         :validate-wallet-value="true"
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
                                                {{ CalendarTools.getMonthNameByNumber(month) }}
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
                                            <td>{{ formatValueToBr(totalSpending.fourthInstallment) }}</td>
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
                                            <td>{{ formatValueToBr(cardsInvoice.fourthInstallment) }}</td>
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
                                            <td>{{ formatValueToBr(totalFutureGain.fourthInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalFutureGain.fifthInstallment) }}</td>
                                            <td>{{ formatValueToBr(totalFutureGain.sixthInstallment) }}</td>
                                        </tr>
                                        <tr class="text-center text-nowrap">
                                            <td>
                                                <font-awesome-icon :icon="iconEnum.wallet()" class="movement-gain-icon me-2"/>
                                            </td>
                                            <td class="text-start">
                                                Carteira
                                                <a href="/carteiras" class="a-default" target="_blank">
                                                    <font-awesome-icon :icon="iconEnum.linkOut()" class="icon-out"/>
                                                </a>
                                            </td>
                                            <td>{{ formatValueToBr(totalWalletsValue) }}</td>
                                        </tr>
                                        <tr class="text-center text-nowrap">
                                            <td>
                                                <font-awesome-icon :icon="iconEnum.circleArrowRight()"
                                                                   class="remaining-icon me-2"/>
                                            </td>
                                            <td class="text-start">Sobras</td>
                                            <td>
                                                {{ formatValueToBr(totalRemaining.firstInstallment + totalWalletsValue) }}
                                                <alert-icon v-if="(totalRemaining.firstInstallment + totalWalletsValue) < 0"/>
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
                                                {{ formatValueToBr(totalRemaining.fourthInstallment) }}
                                                <alert-icon v-if="totalRemaining.fourthInstallment < 0"/>
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
            <divider/>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue'
import Divider from '../../components/DividerComponent.vue'
import MfpTitle from '../../components/TitleComponent.vue'
import iconEnum from '../../../js/enums/iconEnum'
import ActionButtons from '../../components/ActionButtons.vue'
import StringTools from '../../../js/tools/stringTools'
import CalendarTools from '../../../js/tools/calendarTools'
import ApiRouter from '../../../js/router/apiRouter'
import MfpMessage from '../../components/MessageAlert.vue'
import PayReceive from '../../components/PayReceiveComponent.vue'
import AlertIcon from '../../components/AlertIcon.vue'
import messageTools from '../../../js/tools/messageTools'
import MfpExpiresDateBadge from '../../components/date/ExpiresDateBadge.vue'

export default {
    name: 'PanoramaView',
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
        MfpExpiresDateBadge,
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
                countId: 0
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
                fourthInstallment: 0,
                fifthInstallment: 0,
                sixthInstallment: 0
            },
            totalFutureGain: {
                firstInstallment: 0,
                secondInstallment: 0,
                thirdInstallment: 0,
                fourthInstallment: 0,
                fifthInstallment: 0,
                sixthInstallment: 0
            },
            totalRemaining: {
                firstInstallment: 0,
                secondInstallment: 0,
                thirdInstallment: 0,
                fourthInstallment: 0,
                fifthInstallment: 0,
                sixthInstallment: 0
            },
            cardsInvoice: {
                firstInstallment: 0,
                secondInstallment: 0,
                thirdInstallment: 0,
                fourthInstallment: 0,
                fifthInstallment: 0,
                sixthInstallment: 0
            },
            futureSpending: {},
            totalWalletsValue: 0,
            paySpentValue: 0,
            paySpentId: 0,
            showPaySpent: false,
            paySpentName: '',
            paySpentWalletId: 0,
            messageData: {}
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
                this.messageData = messageTools.errorMessage('Não foi possível carregar o panorama!')
            })
        },
        async deleteSpent(id, spentName) {
            if (confirm('Tem certeza que realmente quer deletar a despesa ' + spentName + '?')) {
                await ApiRouter.futureSpent.delete(id).then(() => {
                    this.messageData = messageTools.successMessage('Despesa deletada com sucesso!')
                    this.updateFutureSpendingList()
                }).catch(() => {
                    this.messageData = messageTools.errorMessage('Não foi possível deletar a despesa!')
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
            } else if (spent.fourthInstallment) {
                return spent.fourthInstallment
            } else if (spent.fifthInstallment) {
                return spent.fifthInstallment
            } else if (spent.sixthInstallment) {
                return spent.sixthInstallment
            }
        },
        async paySpent(event) {
            const partial = event.partial ? ' de forma parcial' : ''
            let confirmMessage = 'Você confirma o pagamento da despesa '
            confirmMessage = confirmMessage + '"' + this.paySpentName + '"'
            confirmMessage = confirmMessage + partial
            confirmMessage = confirmMessage + ' no valor de ' + StringTools.formatFloatValueToBrString(event.value)
            if (confirm(confirmMessage + '?')) {
                const object = {
                    walletId: event.walletId,
                    value: event.value,
                    partial: event.partial
                }
                await ApiRouter.futureSpent.pay(this.paySpentId, object).then(() => {
                    this.messageData = messageTools.successMessage('Despesa paga com sucesso!')
                    this.updateFutureSpendingList()
                    this.showPaySpent = false
                }).catch(() => {
                    this.messageData = messageTools.errorMessage('Não foi possível pagar a despesa!')
                })
            }
        },
        showCheckButton(spent) {
            if (
                !spent.firstInstallment &&
                !spent.secondInstallment &&
                !spent.thirdInstallment &&
                !spent.fourthInstallment &&
                !spent.fifthInstallment &&
                !spent.sixthInstallment
            ) {
                return false
            }
            return true
        },
        formatValueToBr(value) {
            return StringTools.formatFloatValueToBrString(value)
        },
        mustShowActionButtons(spent) {
            if (spent.name === 'Mercado') {
                return false
            }
            return true
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
    .border-table {
        border-top: 2px solid $table-line-divider-color;
        border-bottom: 2px solid $table-line-divider-color;
    }
    .border-table-top {
        border-top: 2px solid $table-line-divider-color;
    }
    .no-hover:hover {
        background-color: transparent !important;
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
            margin-bottom: 0.68rem !important;
            margin-top: 0.68rem !important;
        }
        .balance-value {
            white-space: nowrap;
            overflow: hidden;
        }
        .select-balance-value {
            margin-bottom: 1.2rem;
            margin-top: 1.2rem;
        }
    }
</style>