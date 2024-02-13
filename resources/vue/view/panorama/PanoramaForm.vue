<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="title"/>
            </div>
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
                                   v-model="spent.description"
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
                                   v-model="spent.forecast"
                                   required>
                            <label for="first-installment">Primeira Parcela</label>
                        </div>
                    </div>
                </div>
                <input-money :value="spent.amount"
                             title="Valor Parcela"
                             @input-money="spent.amount = $event"
                             :use-floating-labels="true"/>
                <div class="row justify-content-center mt-3">
                    <div class="col-4 text-white">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="fix-spent">
                                Despesa fixa
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
                        <div class="form-floating mb-3">
                            <input type="number"
                                   class="form-control"
                                   id="installments"
                                   placeholder=""
                                   v-model="spent.installments"
                                   min="1"
                                   max="100"
                                   required>
                            <label for="installments">Parcelas restantes</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" :class="spent.fix ? 'mt-3' : 'mt-2'">
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-select" id="wallet" v-model="spent.walletId" required>
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
            <bottom-buttons :redirect-to="redirect" :button-success-text="title" @btn-clicked="updateOrInsertSpent"/>
        </div>
    </div>
</template>

<script>
import MfpTitle from '~vue-component/TitleComponent.vue'
import Divider from '~vue-component/DividerComponent.vue'
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import apiRouter from '~js/router/apiRouter'
import BottomButtons from '~vue-component/BottomButtons.vue'
import { HttpStatusCode } from 'axios'
import InputMoney from '~vue-component/inputMoneyComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import messageTools from '~js/tools/messageTools'

const FIX_SPENT = 0

export default {
    name: 'PanoramaForm',
    components: {
        MfpMessage,
        InputMoney,
        BottomButtons,
        LoadingComponent,
        Divider,
        MfpTitle
    },
    data() {
        return {
            title: '',
            loadingDone: false,
            wallets: {},
            spent: {
                walletId: 0
            },
            redirect: '/panorama',
            messageData: {}
        }
    },
    methods: {
        async updateOrInsertSpent() {
            this.validateSpent()
            if (!this.isValid) {
                return
            }
            if (this.$route.params.id) {
                await this.updateSpent()
                return
            }
            await this.insertSpent()
        },
        validateSpent() {
            let field = null
            if (!this.spent.description) {
                field = 'description'
            } else if (!this.spent.forecast) {
                field = 'primeira parcela'
            } else if (!this.spent.amount || this.spent.amount === 0) {
                field = 'valor'
            } else if (!this.spent.walletId) {
                field = 'carteira'
            } else if (this.spent.fix === false && (!this.spent.installments || this.spent.installments === 0)) {
                field = 'quantidade de vezes'
            }
            if (field) {
                this.messageData = messageTools.invalidFieldMessage(field)
                this.isValid = false
                return
            }
            this.isValid = true
        },
        async updateSpent() {
            await apiRouter.futureSpent.update(this.populateSpent(), this.spent.id).then((response) => {
                if (response.status === HttpStatusCode.Ok) {
                    this.messageData = messageTools.successMessage('Gasto atualizado com sucesso!')
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao atualizar gasto!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
        async insertSpent() {
            await apiRouter.futureSpent.insert(this.populateSpent()).then((response) => {
                if (response.status === HttpStatusCode.Created) {
                    this.messageData = messageTools.successMessage('Gasto cadastrada com sucesso!')
                    this.spent = {}
                    this.spent.fix = false
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao inserir gasto!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
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
                forecast: this.spent.forecast
            }
        }
    },
    async mounted() {
        if (this.$route.params.id) {
            this.title = 'Atualizar Gasto'
            await apiRouter.futureSpent.show(this.$route.params.id).then((response) => {
                this.spent = response
                this.loadingDone = true
            })
            this.spent.forecast = this.spent.forecast.split('T')[0].slice(0, 10)
            this.spent.fix = this.spent.installments === FIX_SPENT
        } else {
            this.title = 'Cadastrar Gasto'
            this.spent.fix = false
            this.loadingDone = true
        }
        if (this.$route.query.referer) {
            this.redirect = '/' + this.$route.query.referer
        }
        this.wallets = await apiRouter.wallet.index()
    }
}
</script>