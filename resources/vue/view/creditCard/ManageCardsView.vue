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
            <div>
                <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th scope="col"><font-awesome-icon :icon="iconEnum.calendarCheck()"/></th>
                            <th scope="col">Cartão</th>
                            <th scope="col">Limite</th>
                            <th scope="col">Limite Restante</th>
                            <th scope="col">Fecha Dia</th>
                            <th scope="col">Próxima Fatura</th>
                            <th scope="col">Data Criação</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-for="card in cards" :key="card.id">
                            <td>{{ card.dueDate }}</td>
                            <td>{{ card.name }}</td>
                            <td>{{ stringTools.formatFloatValueToBrString(card.limit) }}</td>
                            <td>!! Desenvolver !!</td>
                            <td>{{ card.closingDay }}</td>
                            <td>!! Desenvolver !!</td>
                            <td>{{ calendarTools.convertDateDbToBr(card.createdAt) }}</td>
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
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

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
                 await apiRouter.cards.index().then((response) => {
                     this.loadingDone = false
                     this.cards = response
                     this.loadingDone = true
                }).catch((response) => {
                    this.messageError('Erro inesperado ao buscar Cartões!')
                })
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