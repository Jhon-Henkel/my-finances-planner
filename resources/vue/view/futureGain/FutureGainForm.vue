<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <mfp-title :title="title" class="title"/>
            <divider/>
            <form class="was-validated form-floating text-black">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control"
                                   id="description-input"
                                   placeholder=""
                                   minlength="2"
                                   v-model="gain.description"
                                   required>
                            <label for="description-input">Descrição</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-4">
                        <div class="form-floating mb-3">
                            <input type="date"
                                   class="form-control"
                                   id="first-installment"
                                   placeholder=""
                                   v-model="gain.forecast"
                                   required>
                            <label for="first-installment">Primeira Parcela</label>
                        </div>
                    </div>
                </div>
                <input-money :value="gain.amount" @input-money="gain.amount = $event" :use-floating-labels="true"/>
                <div class="row justify-content-center mt-3">
                    <div class="col-4 text-white">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="fix-gain">
                                Despesa fixa
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
                        <div class="form-floating mb-3">
                            <input type="number"
                                   class="form-control"
                                   id="installments"
                                   placeholder=""
                                   v-model="gain.installments"
                                   min="1"
                                   max="48"
                                   required>
                            <label for="installments">Parcelas restantes</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" :class="gain.fix ? 'mt-3' : 'mt-2'">
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-select" id="wallet" v-model="gain.walletId" required>
                                <option value="0" disabled selected>Selecione uma carteira</option>
                                <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
                                    {{ wallet.name }}
                                </option>
                            </select>
                            <label for="wallet">Carteira</label>
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
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import BottomButtons from '~vue-component/BottomButtons.vue'
import apiRouter from '~js/router/apiRouter'
import InputMoney from '~vue-component/inputMoneyComponent.vue'
import { HttpStatusCode } from 'axios'
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import messageTools from '~js/tools/messageTools'

const FIX_GAIN = 0

export default {
    name: 'FutureGainForm',
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
                walletId: 0
            },
            title: '',
            isValid: null,
            loadingDone: false,
            wallets: {},
            redirect: '/ganhos-futuros',
            messageData: {}
        }
    },
    methods: {
        async updateOrInsertGain() {
            this.validateGain()
            if (!this.isValid) {
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
            if (!this.gain.description) {
                field = 'descrição'
            } else if (!this.gain.forecast) {
                field = 'primeira parcela'
            } else if (!this.gain.amount || this.gain.amount === 0) {
                field = 'valor'
            } else if (!this.gain.walletId || this.gain.walletId === 0) {
                field = 'carteira'
            } else if (this.gain.fix === false && (!this.gain.installments || this.gain.installments === 0)) {
                field = 'quantidade de vezes'
            }
            if (field) {
                this.messageData = messageTools.invalidFieldMessage(field)
                this.isValid = false
                return
            }
            this.isValid = true
        },
        async updateGain() {
            await apiRouter.futureGain.update(this.populateGain(), this.gain.id).then((response) => {
                if (response.status === HttpStatusCode.Ok) {
                    this.messageData = messageTools.successMessage('Ganho atualizado com sucesso!')
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao atualizar ganho!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
        async insertGain() {
            await apiRouter.futureGain.insert(this.populateGain()).then((response) => {
                if (response.status === HttpStatusCode.Created) {
                    this.messageData = messageTools.successMessage('Ganho cadastrada com sucesso!')
                    this.gain = {}
                    this.gain.fix = false
                } else {
                    this.messageData = messageTools.errorMessage('Campo "Erro inesperado ao inserir ganho!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
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
                forecast: this.gain.forecast
            }
        },
        async getGain(gainId) {
            this.loadingDone = false
            this.gain = await apiRouter.futureGain.show(gainId)
            this.loadingDone = true
        }
    },
    async mounted() {
        if (this.$route.params.id) {
            this.title = 'Atualizar Ganho'
            await this.getGain(this.$route.params.id)
            this.gain.forecast = this.gain.forecast.split('T')[0].slice(0, 10)
            this.gain.fix = this.gain.installments === FIX_GAIN
        } else {
            this.title = 'Cadastrar Ganho'
            this.gain.fix = false
            this.loadingDone = true
        }
        if (this.$route.query.referer) {
            this.redirect = '/' + this.$route.query.referer
        }
        this.wallets = await apiRouter.wallet.index()
    }
}
</script>

<style scoped>
    @media (max-width: 1000px) {
        .title {
            margin: auto auto auto 75px !important;
        }
    }
</style>