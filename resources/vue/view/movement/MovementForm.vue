<template>
    <mfp-message :message-data="messageData"/>
    <div class="base-container">
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <mfp-title :title="title" class="title"/>
            <divider/>
            <form class="was-validated text-black mt-4">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-floating">
                            <input type="text"
                                   class="form-control"
                                   id="description-input"
                                   placeholder=""
                                   minlength="2"
                                   v-model="movement.description"
                                   required>
                            <label for="description-input">Descrição</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3" v-show="! movement.id">
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-select" id="select-type" v-model="movement.type" required>
                                <option v-for="type in types" :key="type.id" :value="type.id">
                                    {{ type.label }}
                                </option>
                            </select>
                            <label for="select-type">Tipo</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3" v-show="! movement.id">
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-select" id="select-wallet" v-model="movement.walletId" required>
                                <option value="0" disabled>Selecione uma Carteira</option>
                                <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
                                    {{ wallet.name }}
                                </option>
                            </select>
                            <label for="select-wallet">Carteira</label>
                        </div>
                    </div>
                </div>
                <input-money class="mt-2"
                             :value="movement.amount"
                             @input-money="movement.amount = $event"
                             :use-floating-labels="true"/>
            </form>
            <divider/>
            <bottom-buttons redirect-to="/movimentacoes"
                            :button-success-text="title"
                            @btn-clicked="updateOrInsertMovement"/>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue'
import BottomButtons from '../../components/BottomButtons.vue'
import apiRouter from '../../../js/router/apiRouter'
import { HttpStatusCode } from 'axios'
import MovementEnum from '../../../js/enums/movementEnum'
import InputMoney from '../../components/inputMoneyComponent.vue'
import Divider from '../../components/DividerComponent.vue'
import MfpTitle from '../../components/TitleComponent.vue'
import MfpMessage from '../../components/MessageAlert.vue'
import messageTools from '../../../js/tools/messageTools'

export default {
    name: 'MovementForm',
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
            loadingDone: false,
            title: '',
            isValid: false,
            movement: {
                walletId: 0,
                type: MovementEnum.type.spent()
            },
            wallets: {},
            types: {},
            messageData: {}
        }
    },
    methods: {
        async updateOrInsertMovement() {
            this.validateMovement()
            if (!this.isValid) {
                return
            }
            if (this.$route.params.id) {
                await this.updateMovement()
                return
            }
            await this.insertMovement()
        },
        validateMovement() {
            let field = null
            if (!this.movement.description) {
                field = 'descrição'
            } else if (!this.movement.type) {
                field = 'tipo'
            } else if (!this.movement.walletId || this.movement.walletId === 0) {
                field = 'carteira'
            } else if (!this.movement.amount) {
                field = 'valor'
            }
            if (field) {
                this.messageData = messageTools.invalidFieldMessage(field)
                this.isValid = false
                return
            }
            this.isValid = true
        },
        async updateMovement() {
            await apiRouter.movement.update(this.populateMovement(), this.movement.id).then((response) => {
                if (response.status === HttpStatusCode.Ok) {
                    this.messageData = messageTools.successMessage('Movimentação atualizada com sucesso!')
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao atualizar movimentação!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
        async insertMovement() {
            await apiRouter.movement.insert(this.populateMovement()).then((response) => {
                if (response.status === HttpStatusCode.Created) {
                    this.messageData = messageTools.successMessage('Movimentação cadastrada com sucesso!')
                    this.movement = {}
                    this.movement.type = MovementEnum.type.spent()
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao inserir movimentação!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
        populateMovement() {
            return {
                description: this.movement.description,
                type: this.movement.type,
                walletId: this.movement.walletId,
                amount: this.movement.amount
            }
        },
        async getWallets() {
            await apiRouter.wallet.index().then((response) => {
                this.wallets = response
            })
        },
        async getMovement(movementId) {
            await apiRouter.movement.show(movementId).then((response) => {
                this.movement = response
            })
        }
    },
    async mounted() {
        if (this.$route.params.id) {
            this.title = 'Atualizar Movimentação'
            await this.getMovement(this.$route.params.id)
        } else {
            this.title = 'Cadastrar Movimentação'
            this.movement.type = MovementEnum.type.spent()
        }
        await this.getWallets()
        this.loadingDone = true
        this.types = MovementEnum.getTypeListForForm()
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