<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <mfp-title :title="title" class="title"/>
            <divider/>
            <form class="was-validated form-floating text-black">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control"
                                   id="wallet-name-input"
                                   placeholder=""
                                   minlength="2"
                                   v-model="wallet.name"
                                   required>
                            <label for="wallet-name-input">Nome</label>
                        </div>
                    </div>
                </div>
                <input-money :value="wallet.amount" @input-money="wallet.amount = $event" :use-floating-labels="true"/>
                <div class="row justify-content-center mt-2">
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-select" id="expense-credit-card" v-model="wallet.type" required>
                                <option value="0" disabled>Selecione um tipo de conta</option>
                                <option v-for="type in typesOfWallet" :key="type.id" :value="type.id">
                                    {{ type.description }}
                                </option>
                            </select>
                            <label for="expense-credit-card">Cartão de crédito</label>
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <bottom-buttons redirect-to="/carteiras" :button-success-text="title" @btn-clicked="updateOrInsertWallet"/>
        </div>
    </div>
</template>

<script>
import walletEnum from '~js/enums/walletEnum'
import apiRouter from '~js/router/apiRouter'
import { HttpStatusCode } from 'axios'
import iconEnum from '~js/enums/iconEnum'
import InputMoney from '~vue-component/inputMoneyComponent.vue'
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import BottomButtons from '~vue-component/BottomButtons.vue'
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import stringTools from '~js/tools/stringTools'
import messageTools from '~js/tools/messageTools'

export default {
    name: 'WalletFormView',
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
        LoadingComponent,
        InputMoney
    },
    data() {
        return {
            idToUpdate: null,
            wallet: {
                type: 0,
                amount: 0
            },
            title: '',
            isValid: null,
            loadingDone: false,
            messageData: {},
            typesOfWallet: walletEnum.getIdAndDescriptionTypeList()
        }
    },
    methods: {
        async updateOrInsertWallet() {
            this.validateWallet()
            if (!this.isValid) {
                return
            }
            if (this.wallet.id) {
                await this.updateWallet()
            } else {
                await this.insertWallet()
            }
        },
        validateWallet() {
            let field = null
            if (!this.wallet.name || this.wallet.name.length < 2) {
                field = 'nome'
            } else if (this.wallet.type < 0 || this.wallet.type > 10) {
                field = 'tipo de conta'
            }
            if (field) {
                this.messageData = messageTools.invalidFieldMessage(field)
                this.isValid = false
                return
            }
            this.isValid = true
        },
        populateData() {
            return {
                name: this.wallet.name,
                type: this.wallet.type,
                amount: this.wallet.amount
            }
        },
        async updateWallet() {
            const value = stringTools.formatFloatValueToBrString(this.wallet.amount)
            const message = 'Deseja realmente atualizar a carteira "' + this.wallet.name + '" com o valor "' + value + '" ?'
            if (confirm(message) === false) {
                return
            }
            await apiRouter.wallet.update(this.populateData(), this.wallet.id).then((response) => {
                if (response.status === HttpStatusCode.Ok) {
                    this.messageData = messageTools.successMessage('Carteira atualizada com sucesso!')
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao atualizar carteira!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
        async insertWallet() {
            await apiRouter.wallet.insert(this.populateData()).then((response) => {
                if (response.status === HttpStatusCode.Created) {
                    this.messageData = messageTools.successMessage('Carteira cadastrada com sucesso!')
                    this.wallet = {}
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao atualizar carteira!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        }
    },
    async mounted() {
        if (this.$route.params.id) {
            this.title = 'Atualizar Carteira'
            await apiRouter.wallet.show(this.$route.params.id).then((response) => {
                this.wallet = response
                this.loadingDone = true
            })
        } else {
            this.loadingDone = true
            this.title = 'Cadastrar Carteira'
        }
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