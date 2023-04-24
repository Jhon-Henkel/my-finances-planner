<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <message :message="message" :type="messageType" v-show="message" :time="messageTimeOut"/>
            <h3 id="title">{{ title }}</h3>
            <hr class="mb-4">
            <form class="was-validated">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="movement-description">
                                Descrição
                            </label>
                            <input type="text"
                                   class="form-control"
                                   v-model="movement.description"
                                   id="movement-description"
                                   required
                                   minlength="2">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="movement-type">
                                Tipo
                            </label>
                            <select class="form-select"
                                    v-model="movement.type"
                                    id="movement-type"
                                    required>
                                <option v-for="type in types"
                                        :key="type.id"
                                        :value="type.id">
                                    {{ type.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="movement-wallet">
                                Carteira
                            </label>
                            <select class="form-select"
                                    v-model="movement.walletId"
                                    id="movement-wallet"
                                    required>
                                <option v-for="wallet in wallets"
                                        :key="wallet.id"
                                        :value="wallet.id">
                                    {{ wallet.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <input-money :value="movement.amount" @input-money="movement.amount = $event"/>
            </form>
            <hr class="mt-4">
            <bottom-buttons redirect-to="/movimentacoes"
                            :button-success-text="title"
                            @btn-clicked="updateOrInsertMovement"/>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import Message from "../../components/MessageComponent.vue";
    import BottomButtons from "../../components/BottomButtons.vue";
    import CalendarTools from "../../../js/tools/calendarTools";
    import apiRouter from "../../../js/router/apiRouter";
    import messageEnum from "../../../js/enums/messageEnum";
    import {HttpStatusCode} from "axios";
    import MovementEnum from "../../../js/enums/movementEnum";
    import InputMoney from "../../components/inputMoneyComponent.vue";

    export default {
        name: "MovementForm",
        components: {
            InputMoney,
            BottomButtons,
            Message,
            LoadingComponent
        },
        data() {
            return {
                loadingDone: false,
                title: "",
                message: "",
                messageType: "",
                messageTimeOut: CalendarTools.fiveSecondsTimeInMs(),
                isValid: false,
                movement: {},
                wallets: {},
                types: {}
            }
        },
        methods: {
            async updateOrInsertMovement() {
                this.validateMovement()
                if (! this.isValid) {
                    this.resetMessage()
                    return
                }
                if (this.$route.params.id) {
                    await this.updateMovement()
                    return
                }
                await this.insertMovement()
            },
            validateMovement() {
                if (! this.movement.description) {
                    this.message = 'Campo "Descrição" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.movement.type) {
                    this.message = 'Campo "Tipo" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.movement.walletId) {
                    this.message = 'Campo "Carteira" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.movement.amount) {
                    this.message = 'Campo "Valor" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                this.isValid = true
            },
            async updateMovement() {
                await apiRouter.movement.update(this.populateMovement(), this.movement.id).then((response) => {
                    if (response.status === HttpStatusCode.Ok) {
                        this.message = 'Movimentação atualizada com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao atualizar movimentação!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })            },
            async insertMovement() {
                await apiRouter.movement.insert(this.populateMovement()).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.message = 'Movimentação cadastrada com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.movement = {}
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao inserir movimentação!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })            },
            populateMovement() {
                return {
                    description: this.movement.description,
                    type: this.movement.type,
                    walletId: this.movement.walletId,
                    amount: this.movement.amount
                }
            },
            resetMessage() {
                setTimeout(() =>
                    [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            },
        },
        async mounted() {
            if (this.$route.params.id) {
                this.title = 'Atualizar Movimentação'
                this.movement = await apiRouter.movement.show(this.$route.params.id)
            } else {
                this.title = 'Cadastrar Movimentação'
            }
            this.wallets = await apiRouter.wallet.index()
            this.types = MovementEnum.getTypeList()
        }
    }
</script>

<style scoped>

</style>