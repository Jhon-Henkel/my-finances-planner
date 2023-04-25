<template>
    <div class="base-container">
        <message :message="message" :type="messageType" v-show="message"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="title"/>
            </div>
            <divider/>
            <form class="was-validated">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="spent-description">
                                Descrição
                            </label>
                            <input type="text"
                                   class="form-control"
                                   v-model="spent.description"
                                   id="spent-description"
                                   required
                                   minlength="2">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="spent-first-installment">
                                Primeira Parcela
                            </label>
                            <input type="date"
                                   class="form-control"
                                   v-model="spent.forecast"
                                   id="spent-first-installment"
                                   required>
                        </div>
                    </div>
                </div>
                <input-money :value="spent.amount" @input-money="spent.amount = $event"/>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="fix-spent">
                                Gasto fixa
                            </label>
                            <input class="form-check-input"
                                   v-model="spent.fix"
                                   type="checkbox"
                                   role="switch"
                                   id="fix-spent">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3" v-if="spent.fix === false">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="spent-installments">
                                Quantidade de vezes
                            </label>
                            <input type="number"
                                   class="form-control"
                                   v-model="spent.installments"
                                   id="spent-installments"
                                   required
                                   min="1"
                                   max="100">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" :class="spent.fix ? 'mt-3' : 'mt-2'">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="spent-wallet">
                                Carteira
                            </label>
                            <select class="form-select" v-model="spent.walletId" id="spent-wallet" required>
                                <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
                                    {{ wallet.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <bottom-buttons redirect-to="/panorama" :button-success-text="title" @btn-clicked="updateOrInsertSpent"/>
        </div>
    </div>
</template>

<script>
    import MfpTitle from "../../components/TitleComponent.vue";
    import Message from "../../components/MessageComponent.vue";
    import Divider from "../../components/DividerComponent.vue";
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import apiRouter from "../../../js/router/apiRouter";
    import BottomButtons from "../../components/BottomButtons.vue";
    import messageEnum from "../../../js/enums/messageEnum";
    import {HttpStatusCode} from "axios";
    import InputMoney from "../../components/inputMoneyComponent.vue";
    import calendarTools from "../../../js/tools/calendarTools";

    const FIX_SPENT = 0

    export default {
        name: "PanoramaForm",
        components: {
            InputMoney,
            BottomButtons,
            LoadingComponent,
            Divider,
            Message,
            MfpTitle
        },
        data() {
            return {
                title: '',
                loadingDone: false,
                message: null,
                messageType: null,
                wallets: {},
                spent: {},
                messageTimeOut: calendarTools.threeSecondsTimeInMs(),
            }
        },
        methods: {
            async updateOrInsertSpent() {
                this.validateSpent()
                if (! this.isValid) {
                    this.resetMessage()
                    return
                }
                if (this.$route.params.id) {
                    await this.updateSpent()
                    return
                }
                await this.insertSpent()
            },
            validateSpent() {
                if (! this.spent.description) {
                    this.message = 'Campo "Descrição" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.spent.forecast) {
                    this.message = 'Campo "Primeira Parcela" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.spent.amount || this.spent.amount === 0) {
                    this.message = 'Campo "Valor" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.spent.walletId) {
                    this.message = 'Campo "Carteira" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (this.spent.fix === false && (! this.spent.installments || this.spent.installments === 0)) {
                    this.message = 'Campo "Quantidade de vezes" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                this.isValid = true
            },
            async updateSpent() {
                await apiRouter.futureSpent.update(this.populateSpent(), this.spent.id).then((response) => {
                    if (response.status === HttpStatusCode.Ok) {
                        this.message = 'Gasto atualizado com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao atualizar gasto!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })            },
            async insertSpent() {
                await apiRouter.futureSpent.insert(this.populateSpent()).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.message = 'Gasto cadastrada com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.spent = {}
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao inserir gasto!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })            },
            populateSpent() {
                let installmentsToPopulate = FIX_SPENT
                if (this.spent.fix === false) {
                    installmentsToPopulate = this.spent.installments
                }
                return {
                    description: this.spent.description,
                    installments: installmentsToPopulate,
                    amount: this.spent.amount,
                    walletId: this.spent.walletId,
                    forecast: this.spent.forecast,
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
                this.title = 'Atualizar Gasto'
                await apiRouter.futureSpent.show(this.$route.params.id).then((response) => {
                    this.spent = response
                    this.loadingDone = true
                })
                this.spent.forecast = this.spent.forecast.split('T')[0].slice(0, 10)
                this.spent.fix = this.spent.installments === FIX_SPENT;
            } else {
                this.title = 'Cadastrar Gasto'
                this.spent.fix = false
                this.loadingDone = true
            }
            this.wallets = await apiRouter.wallet.index()
        }
    }
</script>