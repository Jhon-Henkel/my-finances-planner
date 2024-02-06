<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Cartões"/>
                <mfp-drop-down-button :buttons-array="buttons"/>
            </div>
            <divider/>
            <div class="glass card mb-2">
                <div class="mb-4 mt-4">
                    <div class="col-12 text-center" v-if="cards.length === 0">
                        Você não possui nenhum cartão cadastrado!
                    </div>
                    <div class="row ms-1 me-1" v-else v-for="card in cards" :key="card.id">
                        <div class="col-11">
                            <div class="row">
                                <div class="col-6">
                                    <strong>{{ card.name }}</strong>
                                </div>
                                <div class="col-3">
                                    <span class="badge rounded-2"
                                          :class="getBadgeTypeForForecastDate(card)"
                                          v-tooltip="getTitleForForecastDate(card)">
                                        <font-awesome-icon :icon="iconEnum.calendarCheck()"/>
                                        {{ card.dueDate }}
                                    </span>
                                </div>
                                <div class="col-3">
                                    <span v-tooltip="'Fecha Dia'">
                                        <font-awesome-icon :icon="iconEnum.calendarXMark()" class="warning-text-color"/>
                                        {{ card.closingDay }}
                                    </span>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 mt-1">
                                            <div class="progress" role="progressbar">
                                                <div :class="'progress-bar ' + getClassProgressBar(card)"
                                                     :style="'width: ' + calcPercentageSpent(card) + '%'" >
                                                    {{ calcPercentageSpent(card) }} %
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-12 text-sm">
                                    Fatura <strong class="danger-text-color">{{ formatMoney(card.nextInvoiceValue) }}</strong>
                                    Limite <strong class="success-text-color">{{ formatMoney(card.limit) }}</strong>
                                    Resta <strong class="warning-text-color">{{ formatMoney(card.limit - card.totalValueSpending) }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 d-flex justify-content-center align-items-center">
                            <div class="dropdown-center">
                                <button class="btn btn-outline-success"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <font-awesome-icon :icon="iconEnum.ellipsisVertical()"/>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <router-link
                                            class="dropdown-item"
                                            :to="'/gerenciar-cartoes/' + card.id + '/atualizar'"
                                            v-tooltip="'Editar'">
                                            <font-awesome-icon :icon="iconEnum.editIcon()" />
                                            Editar
                                        </router-link>
                                    </li>
                                    <li>
                                        <button class="dropdown-item"
                                                @click="deleteCard(card.id, card.name)"
                                                v-tooltip="'Apagar'">
                                            <font-awesome-icon :icon="iconEnum.trashIcon()" />
                                            Apagar
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item"
                                                v-tooltip="'Pagar Fatura'"
                                                @click="payInvoiceForm(card)">
                                            <font-awesome-icon :icon="iconEnum.check()" />
                                            Pagar fatura
                                        </button>
                                    </li>
                                    <li>
                                        <router-link class="dropdown-item"
                                                     :to="'/gerenciar-cartoes/despesa/' + card.id + '/cadastrar'"
                                                     v-tooltip="'Nova Despesa'">
                                            <font-awesome-icon :icon="iconEnum.expense()" />
                                            Nova despesa
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link class="dropdown-item"
                                                     :to="'/gerenciar-cartoes/fatura-cartao/' + card.id"
                                                     v-tooltip="'Ver Fatura'">
                                            <font-awesome-icon :icon="iconEnum.invoice()" />
                                            Ver fatura
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr v-show="mustShowDividerInCard(card.id)">
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <select class="form-select card-select-to-pay"
                        id="pay-invoice"
                        v-model="cardId"
                        v-show="showPayInvoice"
                        disabled>
                    <option v-for="card in cards" :key="card.id" :value="card.id">
                        {{ card.name }}
                    </option>
                </select>
                <select class="form-select" id="pay-invoice" v-model="walletId" v-show="showPayInvoice" required>
                    <option value="0" disabled>Selecione a carteira</option>
                    <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id" @change="walletId = $event">
                        {{ wallet.name }}
                    </option>
                </select>
                <button class="btn btn-success pay-button" type="button" v-show="showPayInvoice" @click="payNextInvoice">
                    <font-awesome-icon :icon="iconEnum.check()" class="me-2"/>
                    Pagar
                </button>
            </div>
            <divider/>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import iconEnum from '~js/enums/iconEnum'
import apiRouter from '~js/router/apiRouter'
import stringTools from '~js/tools/stringTools'
import calendarTools from '~js/tools/calendarTools'
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { HttpStatusCode } from 'axios'
import messageTools from '~js/tools/messageTools'
import MfpDropDownButton from '~vue-component/buttons/DropDownButtonGroup.vue'
import numberTools from '~js/tools/numberTools'

export default {
    name: 'ManageCardsView',
    computed: {
        calendarTools() {
            return calendarTools
        },
        stringTools() {
            return stringTools
        },
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        MfpDropDownButton,
        FontAwesomeIcon,
        MfpMessage,
        MfpTitle,
        Divider,
        LoadingComponent
    },
    data() {
        return {
            cards: [],
            card: {
                totalValueSpending: 0,
                nextInvoiceValue: 0,
                isThinsMouthInvoicePayed: false
            },
            loadingDone: false,
            showPayInvoice: false,
            wallets: {},
            walletId: 0,
            cardId: 0,
            messageData: {},
            buttons: [
                {
                    title: 'Novo Cartão',
                    icon: iconEnum.creditCard(),
                    redirectTo: '/gerenciar-cartoes/cadastrar'
                },
                {
                    title: 'Nova despesa',
                    icon: iconEnum.expense(),
                    redirectTo: '/gerenciar-cartoes/despesa/cadastrar'
                }
            ]
        }
    },
    methods: {
        getBadgeTypeForForecastDate(card) {
            const today = calendarTools.getToday().getDate()
            if (card.isThinsMouthInvoicePayed) {
                return 'text-bg-success'
            } else if (card.dueDate < today) {
                return 'text-bg-danger'
            } else if (card.dueDate > today) {
                return 'text-bg-warning'
            }
        },
        getTitleForForecastDate(card) {
            const today = calendarTools.getToday().getDate()
            const month = calendarTools.getMonthNameByNumber(calendarTools.getThisMonth())
            if (card.isThinsMouthInvoicePayed) {
                return 'Fatura mês ' + month + ' paga'
            } else if (card.dueDate < today) {
                return 'Fatura mês ' + month + ' atrasada'
            } else if (card.dueDate > today) {
                return 'Fatura mês ' + month + ' a vencer'
            }
        },
        async getCards() {
            this.loadingDone = false
            await apiRouter.cards.index().then((response) => {
                this.cards = response
                this.loadingDone = true
            }).catch(() => {
                this.messageData = messageTools.errorMessage('Erro inesperado ao buscar Cartões!')
            })
        },
        async deleteCard(cardId, cardName) {
            if (confirm('Tem certeza que realmente quer deletar o cartão ' + cardName + '?')) {
                await apiRouter.cards.delete(cardId).then(() => {
                    this.messageData = messageTools.successMessage('Cartão deletada com sucesso!')
                    this.getCards()
                }).catch((response) => {
                    this.messageData = messageTools.errorMessage(response.response.data.message)
                })
            }
        },
        formatMoney(value) {
            return stringTools.formatFloatValueToBrString(value)
        },
        calcPercentageSpent(card) {
            return numberTools.getPercentageNumberWithoutPercentSymbol(card.totalValueSpending, card.limit)
        },
        payInvoiceForm(card) {
            this.showPayInvoice = !this.showPayInvoice
            this.cardId = card.id
        },
        getClassProgressBar(card) {
            const percentage = this.calcPercentageSpent(card)
            if (percentage < 80) {
                return 'text-bg-success'
            } else if (percentage >= 80 && percentage < 95) {
                return 'text-bg-warning'
            } else {
                return 'text-bg-danger'
            }
        },
        async payNextInvoice() {
            if (this.cardId === 0) {
                this.messageData = messageTools.warningMessage(
                    'Você deve selecionar um cartão!',
                    'Cartão não informado!'
                )
                return
            }
            if (this.walletId === 0) {
                this.messageData = messageTools.warningMessage(
                    'Você deve selecionar uma carteira!',
                    'Carteira não informada!'
                )
                return
            }
            if (confirm('Deseja realmente pagar a próxima fatura ?')) {
                await apiRouter.cards.invoices.payInvoice(this.walletId, this.cardId).then(async(response) => {
                    if (response.status !== HttpStatusCode.Ok) {
                        this.messageData = messageTools.errorMessage('Erro ao pagar fatura!')
                        return
                    }
                    this.messageData = messageTools.successMessage('Fatura paga com sucesso!')
                    this.showPayInvoice = false
                    await this.getCards()
                    this.walletId = 0
                    this.cardId = 0
                }).catch(() => {
                    this.messageData = messageTools.errorMessage('Erro ao pagar fatura!')
                })
            }
        },
        mustShowDividerInCard(cardId) {
            return this.cards[this.cards.length - 1].id !== cardId
        }
    },
    async mounted() {
        this.getCards()
        this.wallets = await apiRouter.wallet.index()
    }
}
</script>

<style scoped lang="scss">
@import "../../../sass/variables";
.warning-text-color {
    color: $alert-icon-color;
}
.danger-text-color {
    color: $danger-icon-color;
}
.success-text-color {
    color: $success-icon-color;
}
.card-select-to-pay {
    background-image: none;
}
.text-sm {
    font-size: 0.85rem;
}
@media (max-width: 1000px) {
    .nav {
        flex-direction: column;
    }
    .input-group {
        flex-direction: column;
    }
    .form-select {
        margin-bottom: 10px;
        width: 100% !important;
        border-radius: 8px !important;
    }
    .pay-button,
    .show-pay-options {
        width: 100%;
        border-radius: 8px !important;
    }
    .show-pay-options {
        margin-bottom: 10px;
    }
    .text-sm {
        font-size: 0.6rem;
    }
}
</style>