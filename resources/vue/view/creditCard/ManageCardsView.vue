<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Cartões"/>
                <router-link class="btn btn-success rounded-2 top-button" to="/gerenciar-cartoes/cadastrar">
                    <font-awesome-icon :icon="iconEnum.creditCard()" class="me-2"/>
                    Novo Cartão
                </router-link>
                <router-link class="btn btn-success rounded-2 ms-2 top-button" to="/gerenciar-cartoes/despesa/cadastrar">
                    <font-awesome-icon :icon="iconEnum.expense()" class="me-2"/>
                    Nova despesa
                </router-link>
            </div>
            <divider/>
            <div class="card glass success balance-card">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col"><font-awesome-icon :icon="iconEnum.calendarCheck()"/></th>
                                        <th scope="col">Cartão</th>
                                        <th scope="col">Limite</th>
                                        <th scope="col">Limite Restante</th>
                                        <th scope="col">Fecha Dia</th>
                                        <th scope="col">Valor Fatura</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center table-body-hover">
                                    <tr v-show="cards.length === 0">
                                        <td colspan="7">Nenhum cartão cadastrado ainda!</td>
                                    </tr>
                                    <tr v-for="card in cards" :key="card.id">
                                        <td>
                                            <span class="badge rounded-2"
                                                :class="getBadgeTypeForForecastDate(card)"
                                                v-tooltip="getTitleForForecastDate(card)">
                                                {{ card.dueDate }}
                                            </span>
                                        </td>
                                        <td>{{ card.name }}</td>
                                        <td>{{ stringTools.formatFloatValueToBrString(card.limit) }}</td>
                                        <td>{{ stringTools.formatFloatValueToBrString(card.limit - card.totalValueSpending) }}</td>
                                        <td>{{ card.closingDay }}</td>
                                        <td>{{ stringTools.formatFloatValueToBrString(card.nextInvoiceValue) }}</td>
                                        <td>
                                            <action-buttons :delete-tooltip="'Deletar Cartão'"
                                                            :tooltip-edit="'Editar Cartão'"
                                                            :info-tooltip="'Consultar Faturas'"
                                                            :info-to="'/gerenciar-cartoes/fatura-cartao/' + card.id"
                                                            :show-info-button="true"
                                                            :edit-to="'/gerenciar-cartoes/' + card.id + '/atualizar'"
                                                            @delete-clicked="deleteCard(card.id, card.name)"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <divider/>
            <div>
                <div class="input-group mb-3">
                    <button class="btn btn-success show-pay-options"
                            :class="showPayInvoice ? '' : 'rounded-2'"
                            @click="showPayInvoice = !showPayInvoice">
                        <font-awesome-icon :icon="iconEnum.paying()" class="me-2"/>
                        Pagar próxima fatura
                    </button>
                    <select class="form-select" id="pay-invoice" v-model="cardId" v-show="showPayInvoice" required>
                        <option value="0" disabled>Selecione o cartão</option>
                        <option v-for="card in cards" :key="card.id" :value="card.id" @change="cardId = $event">
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
            </div>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue'
import iconEnum from '../../../js/enums/iconEnum'
import apiRouter from '../../../js/router/apiRouter'
import stringTools from '../../../js/tools/stringTools'
import calendarTools from '../../../js/tools/calendarTools'
import ActionButtons from '../../components/ActionButtons.vue'
import Divider from '../../components/DividerComponent.vue'
import MfpTitle from '../../components/TitleComponent.vue'
import MfpMessage from '../../components/MessageAlert.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { HttpStatusCode } from 'axios'
import messageTools from '../../../js/tools/messageTools'

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
        FontAwesomeIcon,
        MfpMessage,
        MfpTitle,
        Divider,
        ActionButtons,
        LoadingComponent
    },
    data() {
        return {
            cards: {},
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
            messageData: {}
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
        async payNextInvoice() {
            if (this.cardId === 0) {
                this.messageData = messageTools.warningMessage('Você deve selecionar um cartão!', 'Cartão não informado!')
                return
            }
            if (this.walletId === 0) {
                this.messageData = messageTools.warningMessage('Você deve selecionar uma carteira!', 'Carteira não informada!')
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
        }
    },
    async mounted() {
        this.getCards()
        this.wallets = await apiRouter.wallet.index()
    }
}
</script>

<style scoped>
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
    }
</style>