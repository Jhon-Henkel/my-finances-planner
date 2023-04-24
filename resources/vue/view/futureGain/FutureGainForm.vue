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
                            <label class="form-label" for="gain-description">
                                Descrição
                            </label>
                            <input type="text"
                                   class="form-control"
                                   v-model="gain.description"
                                   id="gain-description"
                                   required
                                   minlength="2">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="gain-first-installment">
                                Primeira Parcela
                            </label>
                            <input type="date"
                                   class="form-control"
                                   v-model="gain.forecast"
                                   id="gain-first-installment"
                                   required>
                        </div>
                    </div>
                </div>
                <input-money :value="gain.amount" @input-money="updateGainAmountFromEvent"/>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="fix-gain">
                                Ganho fixa
                            </label>
                            <input class="form-check-input"
                                   v-model="gain.fix"
                                   type="checkbox"
                                   role="switch"
                                   id="fix-gain">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3" v-if="gain.fix === false">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="gain-installments">
                                Quantidade de vezes
                            </label>
                            <input type="number"
                                   class="form-control"
                                   v-model="gain.installments"
                                   id="gain-installments"
                                   required
                                   min="1"
                                   max="48">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" :class="gain.fix ? 'mt-3' : 'mt-2'">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="gain-wallet">
                                Carteira
                            </label>
                            <select class="form-select"
                                    v-model="gain.walletId"
                                    id="gain-wallet"
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
            </form>
            <divider/>
            <bottom-buttons redirect-to="/ganhos-futuros"
                            :button-success-text="title"
                            @btn-clicked="updateOrInsertGain"/>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import BottomButtons from "../../components/BottomButtons.vue";
    import calendarTools from "../../../js/tools/calendarTools";
    import Message from "../../components/MessageComponent.vue";
    import apiRouter from "../../../js/router/apiRouter";
    import InputMoney from "../../components/inputMoneyComponent.vue";
    import messageEnum from "../../../js/enums/messageEnum";
    import {HttpStatusCode} from "axios";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";

    const FIX_GAIN = 0

    export default {
        name: "FutureGainForm",
        components: {
            MfpTitle,
            Divider,
            InputMoney,
            Message,
            BottomButtons,
            LoadingComponent
        },
        data() {
            return {
                gain: {},
                title: '',
                message: null,
                messageType: null,
                isValid: null,
                loadingDone: false,
                wallets: {},
                messageTimeOut: calendarTools.threeSecondsTimeInMs(),
            }
        },
        methods: {
            async updateOrInsertGain() {
                this.validateGain()
                if (! this.isValid) {
                    this.resetMessage()
                    return
                }
                if (this.gain.id) {
                    await this.updateGain()
                } else {
                    await this.insertGain()
                }
            },
            validateGain() {
                if (! this.gain.description) {
                    this.message = 'Campo "Descrição" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.gain.forecast) {
                    this.message = 'Campo "Primeira Parcela" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.gain.amount || this.gain.amount === 0) {
                    this.message = 'Campo "Valor" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.gain.walletId) {
                    this.message = 'Campo "Carteira" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (this.gain.fix === false && (! this.gain.installments || this.gain.installments === 0)) {
                    this.message = 'Campo "Quantidade de vezes" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                this.isValid = true
            },
            async updateGain() {
                await apiRouter.futureGain.update(this.populateGain(), this.gain.id).then((response) => {
                    if (response.status === HttpStatusCode.Ok) {
                        this.message = 'Ganho atualizado com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao atualizar ganho!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })
            },
            async insertGain() {
                await apiRouter.futureGain.insert(this.populateGain()).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.message = 'Ganho cadastrada com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.gain = {}
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao inserir ganho!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })
            },
            populateGain() {
                let installmentsToPopulate = FIX_GAIN
                if (this.gain.fix === false) {
                    installmentsToPopulate = this.gain.installments
                }
                return {
                    description: this.gain.description,
                    installments: installmentsToPopulate,
                    amount: this.gain.amount,
                    walletId: this.gain.walletId,
                    forecast: this.gain.forecast,
                }
            },
            resetMessage() {
                setTimeout(() =>
                        [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            },
            updateGainAmountFromEvent(event) {
                this.gain.amount = event
            }
        },
        async mounted() {
            if (this.$route.params.id) {
                this.title = 'Atualizar Ganho'
                this.gain = await apiRouter.futureGain.show(this.$route.params.id)
                this.gain.forecast = this.gain.forecast.split('T')[0].slice(0, 10)
                this.gain.fix = this.gain.installments === FIX_GAIN;
            } else {
                this.title = 'Cadastrar Ganho'
                this.gain.fix = false
            }
            this.wallets = await apiRouter.wallet.index()
        }
    }
</script>