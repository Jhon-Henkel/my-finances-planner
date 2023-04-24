<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <message :message="message" :type="messageType" v-show="message" :time="messageTimeOut"/>
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
                <input-money :value="card.limit" :title="'Limite'" @input-money="updateCardLimitFromEvent"/>
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
    import Message from "../../components/MessageComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import calendarTools from "../../../js/tools/calendarTools";
    import apiRouter from "../../../js/router/apiRouter";
    import InputMoney from "../../components/inputMoneyComponent.vue";
    import messageEnum from "../../../js/enums/messageEnum";
    import {HttpStatusCode} from "axios";
    import BottomButtons from "../../components/BottomButtons.vue";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";

    export default {
        name: "ManageCardsFormView",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            MfpTitle,
            Divider,
            BottomButtons,
            InputMoney,
            Message,
            LoadingComponent
        },
        data() {
            return {
                card: {},
                title: '',
                message: null,
                messageType: null,
                isValid: null,
                loadingDone: false,
                messageTimeOut: calendarTools.threeSecondsTimeInMs(),
            }
        },
        methods: {
            async updateOrInsertCard() {
                this.validateWallet()
                if (! this.isValid) {
                    this.resetMessage()
                    return
                }
                if (this.card.id) {
                    await this.updateCard()
                } else {
                    await this.insertCard()
                }
            },
            validateWallet() {
                if (! this.card.name || this.card.name.length < 2) {
                    this.message = 'Campo "nome" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.card.limit) {
                    this.message = 'Campo "limite" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.card.dueDate) {
                    this.message = 'Campo "vence dia" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.card.closingDay) {
                    this.message = 'Campo "fecha dia" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (this.card.closingDay > this.card.dueDate) {
                    this.message = 'Campo "fecha dia" não pode ser maior que "vence dia"!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                this.isValid = true
            },
            async updateCard() {
                await apiRouter.cards.update(this.populateData(), this.card.id).then((response) => {
                    if (response.status === HttpStatusCode.Ok) {
                        this.message = 'Cartão atualizado com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao atualizar cartão!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })
            },
            async insertCard() {
                await apiRouter.cards.insert(this.populateData()).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.message = 'Cartão cadastrada com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.card = {}
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao inserir cartão!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
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
            resetMessage() {
                setTimeout(() =>
                    [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            },
            updateCardLimitFromEvent(event) {
                this.card.limit = event
            }
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