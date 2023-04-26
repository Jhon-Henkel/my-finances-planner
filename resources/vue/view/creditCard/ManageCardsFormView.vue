<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <mfp-title :title="title"/>
            <divider/>
            <form class="was-validated">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="card-name">
                                Nome
                            </label>
                            <input type="text"
                                   class="form-control"
                                   v-model="card.name"
                                   id="card-name"
                                   required
                                   minlength="2">
                        </div>
                    </div>
                </div>
                <input-money :value="card.limit" :title="'Limite'" @input-money="card.limit = $event"/>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group mt-2">
                            <label class="form-label" for="card-closing-day">
                                Fecha dia
                            </label>
                            <input type="number"
                                   class="form-control"
                                   v-model="card.closingDay"
                                   id="card-closing-day"
                                   required
                                   min="1"
                                   max="31"
                                   minlength="1">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group mt-2">
                            <label class="form-label" for="card-due-date">
                                Vence Dia
                            </label>
                            <input type="number"
                                   class="form-control"
                                   v-model="card.dueDate"
                                   id="card-due-date"
                                   required
                                   min="1"
                                   max="31"
                                   minlength="1">
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <bottom-buttons redirect-to="/gerenciar-cartoes"
                            :button-success-text="title"
                            @btn-clicked="updateOrInsertCard"/>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import apiRouter from "../../../js/router/apiRouter";
    import InputMoney from "../../components/inputMoneyComponent.vue";
    import {HttpStatusCode} from "axios";
    import BottomButtons from "../../components/BottomButtons.vue";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import MfpMessage from "../../components/MessageAlert.vue";
    import MessageEnum from "../../../js/enums/messageEnum";

    export default {
        name: "ManageCardsFormView",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            MfpMessage,
            MfpTitle,
            Divider,
            BottomButtons,
            InputMoney,
            LoadingComponent
        },
        data() {
            return {
                card: {},
                title: '',
                isValid: null,
                loadingDone: false,
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
            async updateOrInsertCard() {
                this.validateWallet()
                if (! this.isValid) {
                    return
                }
                if (this.card.id) {
                    await this.updateCard()
                } else {
                    await this.insertCard()
                }
            },
            validateWallet() {
                let field = null
                if (! this.card.name || this.card.name.length < 2) {
                    field = 'nome'
                } else if (! this.card.limit) {
                    field = 'limite'
                } else if (! this.card.dueDate) {
                    field = 'vence dia'
                } else if (! this.card.closingDay) {
                    field = 'fecha dia'
                }
                if (field) {
                    this.showMessage(
                        MessageEnum.alertTypeInfo(),
                        'Campo "' + field + '" é inválido!',
                        'Campo inválido!'
                    )
                    this.isValid = false
                    return
                }
                this.isValid = true
            },
            async updateCard() {
                await apiRouter.cards.update(this.populateData(), this.card.id).then((response) => {
                    if (response.status === HttpStatusCode.Ok) {
                        this.messageSuccess('Cartão atualizado com sucesso!')
                        return
                    }
                    this.messageError('Erro inesperado ao atualizar cartão!')
                }).catch((response) => {
                    this.messageError(response.response.data.error)
                })
            },
            async insertCard() {
                await apiRouter.cards.insert(this.populateData()).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.messageSuccess('Cartão cadastrada com sucesso!')
                        this.card = {}
                    } else {
                        this.messageError('Erro inesperado ao inserir cartão!')
                    }
                }).catch((response) => {
                    this.messageError(response.response.data.error)
                })
            },
            populateData() {
                return {
                    name: this.card.name,
                    limit: this.card.limit,
                    dueDate: this.card.dueDate,
                    closingDay: this.card.closingDay
                }
            },
        },
        async mounted() {
            if (this.$route.params.id) {
                this.title = 'Atualizar Cartão'
                this.card = await apiRouter.cards.show(this.$route.params.id)
            } else {
                this.title = 'Cadastrar Cartão'
            }
        }
    }
</script>