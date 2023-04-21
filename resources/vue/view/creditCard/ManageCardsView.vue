<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <message :message="message" :type="messageType" v-show="message"/>
            <div class="nav mt-2 justify-content-end">
                <h3 id="title">Cartões</h3>
                <router-link class="btn btn-success rounded-5 me-2" to="/gerenciar-cartoes/cadastrar">
                    <font-awesome-icon :icon="iconEnum.creditCard()" class="me-2"/>
                    Novo Cartão
                </router-link>
                <router-link class="btn btn-success rounded-5" to="/gerenciar-cartoes/despesa/cadastrar">
                    <font-awesome-icon :icon="iconEnum.expense()" class="me-2"/>
                    Nova despesa
                </router-link>
            </div>
            <hr>
            <div class="mt-4">
                <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" scope="col">Cartão</th>
                            <th class="text-center" scope="col">Limite</th>
                            <th class="text-center" scope="col">Vence Dia</th>
                            <th class="text-center" scope="col">Fecha Dia</th>
                            <th class="text-center" scope="col">Próxima Fatura</th>
                            <th class="text-center" scope="col">Data Criação</th>
                            <th class="text-center" scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="card in cards" :key="card.id">
                            <td class="text-center">{{ card.name }}</td>
                            <td class="text-center">{{ stringTools.formatFloatValueToBrString(card.limit) }}</td>
                            <td class="text-center">{{ card.dueDate }}</td>
                            <td class="text-center">{{ card.closingDay }}</td>
                            <!-- todo fazer o get do valor total da fatura -->
                            <td class="text-center">Valor Fatura</td>
                            <td class="text-center">{{ calendarTools.convertDateDbToBr(card.createdAt) }}</td>
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
            <hr class="mt-4">
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import Message from "../../components/MessageComponent.vue";
    import CalendarTools from "../../../js/tools/calendarTools";
    import iconEnum from "../../../js/enums/iconEnum";
    import apiRouter from "../../../js/router/apiRouter";
    import messageEnum from "../../../js/enums/messageEnum";
    import stringTools from "../../../js/tools/stringTools";
    import calendarTools from "../../../js/tools/calendarTools";
    import ActionButtons from "../../components/ActionButtons.vue";

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
            ActionButtons,
            Message,
            LoadingComponent
        },
        data() {
            return {
                cards: {},
                message: null,
                messageTimeOut: CalendarTools.fiveSecondsTimeInMs(),
                messageType: null,
                loadingDone: false
            }
        },
        methods: {
            async getCards() {
                this.cards = await apiRouter.cards.index()
            },
            async deleteCard(cardId, cardName) {
                if(confirm("Tem certeza que realmente quer deletar o cartão " + cardName + '?')) {
                    await apiRouter.cards.delete(cardId).then((response) => {
                        this.message = 'Cartão deletada com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.getCards()
                    }).catch((response) => {
                        this.message = 'Erro inesperado ao deletar Cartão!'
                        this.messageType = messageEnum.messageTypeError()
                    })
                    this.resetMessage()
                }
            },
            resetMessage() {
                $(window).scrollTop(0, 0)
                setTimeout(() =>
                    [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            }
        },
        mounted() {
            this.getCards()
        }
    }
</script>