<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Cartões'"/>
                <router-link class="btn btn-success rounded-5 me-2" to="/gerenciar-cartoes/cadastrar">
                    <font-awesome-icon :icon="iconEnum.creditCard()" class="me-2"/>
                    Novo Cartão
                </router-link>
                <router-link class="btn btn-success rounded-5" to="/gerenciar-cartoes/despesa/cadastrar">
                    <font-awesome-icon :icon="iconEnum.expense()" class="me-2"/>
                    Nova despesa
                </router-link>
            </div>
            <divider/>
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark text-center">
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
                <tbody class="text-center">
                    <tr v-show="cards.length === 0">
                        <td colspan="7">Nenhum cartão cadastrado ainda!</td>
                    </tr>
                    <tr v-for="card in cards" :key="card.id">
                        <td>
                            <span class="badge rounded-5"
                                  :class="getBadgeTypeForForecastDate(card)"
                                  :title="getTitleForForecastDate(card)">
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
            <divider/>
            <div>
                <div class="input-group mb-3">
                    <button class="btn btn-success"
                            :class="showPayInvoice ? '' : 'rounded-5'"
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
                    <button class="btn btn-success" type="button" v-show="showPayInvoice" @click="payNextInvoice">
                        <font-awesome-icon :icon="iconEnum.check()" class="me-2"/>
                        Pagar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import apiRouter from "../../../js/router/apiRouter";
    import stringTools from "../../../js/tools/stringTools";
    import calendarTools from "../../../js/tools/calendarTools";
    import ActionButtons from "../../components/ActionButtons.vue";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import MfpMessage from "../../components/MessageAlert.vue";
    import MessageEnum from "../../../js/enums/messageEnum";
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import {HttpStatusCode} from "axios";

    export default {
        name: "ManageCardsView",
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
            }
        },
        methods: {
            messageError(message) {
                this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
            },
            messageWarning(message, title) {
                this.showMessage(MessageEnum.alertTypeWarning(), message, title)
            },
            messageSuccess(message) {
                this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
            },
            showMessage(type, message, title) {
                this.$refs.message.showAlert(type, message, title)
            },
            getBadgeTypeForForecastDate(card) {
                return card.isThinsMouthInvoicePayed ? 'text-bg-success' : 'text-bg-danger'
            },
            getTitleForForecastDate(card) {
                let month = calendarTools.getMonthNameByNumber(calendarTools.getThisMonth())
                return card.isThinsMouthInvoicePayed
                    ? 'Fatura mês ' + month + ' paga'
                    : 'Fatura mês ' + month + ' não paga'
            },
            async getCards() {
                this.loadingDone = false
                 await apiRouter.cards.index().then((response) => {
                     this.cards = response
                     this.loadingDone = true
                }).catch(() => {
                    this.messageError('Erro inesperado ao buscar Cartões!')
                })
            },
            async deleteCard(cardId, cardName) {
                if(confirm("Tem certeza que realmente quer deletar o cartão " + cardName + '?')) {
                    await apiRouter.cards.delete(cardId).then(() => {
                        this.messageSuccess('Cartão deletada com sucesso!')
                        this.getCards()
                    }).catch((response) => {
                        this.messageError(response.response.data.message)
                    })
                }
            },
            async payNextInvoice() {
                if (this.cardId === 0) {
                    this.messageWarning('Você deve selecionar um cartão!', 'Cartão não informado!')
                    return
                }
                if (this.walletId === 0) {
                    this.messageWarning('Você deve selecionar uma carteira!', 'Carteira não informada!')
                    return
                }
                if (confirm('Deseja realmente pagar a próxima fatura ?')) {
                    await apiRouter.cards.invoices.payInvoice(this.walletId, this.cardId).then(async (response) => {
                        if (response.status !== HttpStatusCode.Ok) {
                            this.messageError('Erro ao pagar fatura!')
                            return
                        }
                        this.messageSuccess('Fatura paga com sucesso!')
                        this.showPayInvoice = false
                        await this.getCards()
                    }).catch(() => {
                        this.messageError('Erro ao pagar fatura!')
                    })
                }
            },
        },
        async mounted() {
            this.getCards()
            this.wallets = await apiRouter.wallet.index()
        }
    }
</script>