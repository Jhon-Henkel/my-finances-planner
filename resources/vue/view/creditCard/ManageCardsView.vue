<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
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
            <div>
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
            <divider/>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import CalendarTools from "../../../js/tools/calendarTools";
    import iconEnum from "../../../js/enums/iconEnum";
    import apiRouter from "../../../js/router/apiRouter";
    import stringTools from "../../../js/tools/stringTools";
    import calendarTools from "../../../js/tools/calendarTools";
    import ActionButtons from "../../components/ActionButtons.vue";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import MfpMessage from "../../components/MessageAlert.vue";
    import MessageEnum from "../../../js/enums/messageEnum";

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
            MfpMessage,
            MfpTitle,
            Divider,
            ActionButtons,
            LoadingComponent
        },
        data() {
            return {
                cards: {},
                loadingDone: false
            }
        },
        methods: {
            messageError(message) {
                this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
            },
            messageSuccess(message) {
                this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
            },
            showMessage(type, message, title) {
                this.$refs.message.showAlert(type, message, title)
            },
            async getCards() {
                this.cards = await apiRouter.cards.index()
            },
            async deleteCard(cardId, cardName) {
                if(confirm("Tem certeza que realmente quer deletar o cartão " + cardName + '?')) {
                    await apiRouter.cards.delete(cardId).then((response) => {
                        this.messageSuccess('Cartão deletada com sucesso!')
                        this.getCards()
                    }).catch((response) => {
                        this.messageError('Erro inesperado ao deletar Cartão!')
                    })
                }
            },
        },
        mounted() {
            this.getCards()
        }
    }
</script>