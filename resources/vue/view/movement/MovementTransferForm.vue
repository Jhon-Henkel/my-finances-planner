<template>
    <mfp-message :message-data="messageData"/>
    <div class="base-container">
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <mfp-title :title="title" class="title"/>
            <divider/>
            <form class="was-validated mt-4 text-black">
                <input-money :value="transfer.amount" @input-money="transfer.amount = $event" :use-floating-labels="true"/>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-select" id="origin" v-model="transfer.originId" required>
                                <option value="0" disabled selected>Selecione uma carteira de origem</option>
                                <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
                                    {{ wallet.name }}
                                </option>
                            </select>
                            <label for="origin">Carteira Origem</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-4 text-center">
                        <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="transfer-icon me-2"/>
                        <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="transfer-icon me-2"/>
                        <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="transfer-icon"/>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-select" id="destination" v-model="transfer.destinationId" required>
                                <option value="0" disabled selected>Selecione uma carteira de destino</option>
                                <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
                                    {{ wallet.name }}
                                </option>
                            </select>
                            <label for="destination">Carteira Origem</label>
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <bottom-buttons redirect-to="/movimentacoes" :button-success-text="title" @btn-clicked="insertTransfer"/>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import Divider from '~vue-component/DividerComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import BottomButtons from '~vue-component/BottomButtons.vue'
import apiRouter from '~js/router/apiRouter'
import InputMoney from '~vue-component/inputMoneyComponent.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import iconEnum from '~js/enums/iconEnum'
import { HttpStatusCode } from 'axios'
import messageTools from '~js/tools/messageTools'

export default {
    name: 'MovementTransferForm',
    computed: {
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        FontAwesomeIcon,
        InputMoney,
        BottomButtons,
        MfpTitle,
        MfpMessage,
        Divider,
        LoadingComponent
    },
    data() {
        return {
            loadingDone: false,
            title: 'Cadastrar Transferência',
            wallets: {},
            isValid: false,
            transfer: {
                amount: 0,
                originId: 0,
                destinationId: 0
            },
            messageData: {}
        }
    },
    methods: {
        async insertTransfer() {
            this.validateMovement()
            if (!this.isValid) {
                return
            }
            await apiRouter.movement.insertTransfer(this.populateMovement()).then((response) => {
                if (response.status === HttpStatusCode.Created) {
                    this.messageData = messageTools.successMessage('Transferência cadastrada com sucesso!')
                    this.transfer = {
                        amount: 0,
                        originId: 0,
                        destinationId: 0
                    }
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao inserir transferência!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
        populateMovement() {
            return {
                amount: this.transfer.amount,
                originId: this.transfer.originId,
                destinationId: this.transfer.destinationId
            }
        },
        async getWallets() {
            await apiRouter.wallet.index().then((response) => {
                this.wallets = response
            })
        },
        validateMovement() {
            let field = null
            if (!this.transfer.amount) {
                field = 'valor'
            } else if (!this.transfer.originId || this.transfer.originId === 0) {
                field = 'carteira de origem'
            } else if (!this.transfer.destinationId || this.transfer.destinationId === 0) {
                field = 'carteira de destino'
            } else if (this.transfer.originId === this.transfer.destinationId) {
                field = 'carteira de origem e destino'
            }
            if (field) {
                this.messageData = messageTools.invalidFieldMessage(field)
                this.isValid = false
                return
            }
            this.isValid = true
        }
    },
    async mounted() {
        await this.getWallets()
        this.loadingDone = true
    }
}
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .transfer-icon {
        color: $success-icon-color;
    }
    @media (max-width: 1000px) {
        .title {
            margin: auto auto auto 75px !important;
        }
    }
</style>