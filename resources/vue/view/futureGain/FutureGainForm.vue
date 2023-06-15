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
                <input-money :value="gain.amount" @input-money="gain.amount = $event"/>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="fix-gain">
                                Ganho fixa
                            </label>
                            <input class="form-check-input" v-model="gain.fix" type="checkbox" role="switch" id="fix-gain">
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
                            <select class="form-select" v-model="gain.walletId" id="gain-wallet" required>
                                <option value="0" disabled selected>Selecione uma carteira</option>
                                <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
                                    {{ wallet.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <bottom-buttons :redirect-to="redirect" :button-success-text="title" @btn-clicked="updateOrInsertGain"/>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import BottomButtons from "../../components/BottomButtons.vue";
    import apiRouter from "../../../js/router/apiRouter";
    import InputMoney from "../../components/inputMoneyComponent.vue";
    import {HttpStatusCode} from "axios";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import MessageEnum from "../../../js/enums/messageEnum";
    import MfpMessage from "../../components/MessageAlert.vue";

    const FIX_GAIN = 0

    export default {
        name: "FutureGainForm",
        components: {
            MfpMessage,
            MfpTitle,
            Divider,
            InputMoney,
            BottomButtons,
            LoadingComponent
        },
        data() {
            return {
                gain: {
                    walletId: 0,
                },
                title: '',
                isValid: null,
                loadingDone: false,
                wallets: {},
                redirect: '/ganhos-futuros',
            }
        },
        methods: {
            async updateOrInsertGain() {
                this.validateGain()
                if (! this.isValid) {
                    return
                }
                if (this.gain.id) {
                    await this.updateGain()
                } else {
                    await this.insertGain()
                }
            },
            validateGain() {
                let field = null
                if (! this.gain.description) {
                    field = 'descrição'
                } else if (! this.gain.forecast) {
                    field = 'primeira parcela'
                } else if (! this.gain.amount || this.gain.amount === 0) {
                    field = 'valor'
                } else if (! this.gain.walletId || this.gain.walletId === 0) {
                    field = 'carteira'
                } else if (this.gain.fix === false && (! this.gain.installments || this.gain.installments === 0)) {
                    field = 'quantidade de vezes'
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
            async updateGain() {
                await apiRouter.futureGain.update(this.populateGain(), this.gain.id).then((response) => {
                    if (response.status === HttpStatusCode.Ok) {
                        this.messageSuccess('Ganho atualizado com sucesso!')
                    } else {
                        this.messageError('Erro inesperado ao atualizar ganho!')
                    }
                }).catch((response) => {
                    this.messageError(response.response.data.error)
                })
            },
            async insertGain() {
                await apiRouter.futureGain.insert(this.populateGain()).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.messageSuccess('Ganho cadastrada com sucesso!')
                        this.gain = {}
                        this.gain.fix = false
                    } else {
                        this.showMessage('Campo "Erro inesperado ao inserir ganho!')
                    }
                }).catch((response) => {
                    this.messageError(response.response.data.error)
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
            messageError(message) {
                this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
            },
            messageSuccess(message) {
                this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
            },
            showMessage(type, message, title) {
                this.$refs.message.showAlert(type, message, title)
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
            if (this.$route.query.referer) {
                this.redirect = '/' + this.$route.query.referer
            }
            this.wallets = await apiRouter.wallet.index()
        }
    }
</script>