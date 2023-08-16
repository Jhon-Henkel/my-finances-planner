<template>
    <mfp-message ref="message"/>
    <div class="base-container">
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <mfp-title :title="title" class="title"/>
            <divider/>
            <input-money :value="transfer.amount" @input-money="transfer.amount = $event"/>
            <form>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="origin">
                                Carteira Origem
                            </label>
                            <select class="form-select" v-model="transfer.originId" id="origin" required>
                                <option value="0" disabled selected>Selecione uma carteira de origem</option>
                                <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
                                    {{ wallet.name }}
                                </option>
                            </select>
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
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="destination">
                                Carteira Destino
                            </label>
                            <select class="form-select" v-model="transfer.destinationId" id="destination" required>
                                <option value="0" disabled selected>Selecione uma carteira de destino</option>
                                <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
                                    {{ wallet.name }}
                                </option>
                            </select>
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
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import Divider from "../../components/DividerComponent.vue";
    import MfpMessage from "../../components/MessageAlert.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import BottomButtons from "../../components/BottomButtons.vue";
    import apiRouter from "../../../js/router/apiRouter";
    import InputMoney from "../../components/inputMoneyComponent.vue";
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import iconEnum from "../../../js/enums/iconEnum";
    import MessageEnum from "../../../js/enums/messageEnum";
    import {HttpStatusCode} from "axios";

    export default {
        name: "MovementTransferForm",
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
                title: "Cadastrar Transferência",
                wallets: {},
                isValid: false,
                transfer: {
                    amount: 0,
                    originId: 0,
                    destinationId: 0
                }
            }
        },
        methods: {
            async insertTransfer() {
                this.validateMovement()
                if (! this.isValid) {
                    return
                }
                await apiRouter.movement.insertTransfer(this.populateMovement()).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.messageSuccess('Transferência cadastrada com sucesso!')
                        this.transfer = {
                            amount: 0,
                            originId: 0,
                            destinationId: 0
                        }
                    } else {
                        this.messageError('Erro inesperado ao inserir transferência!')
                    }
                }).catch((response) => {
                    this.messageError(response.response.data.error)
                })
            },
            populateMovement() {
                return {
                    amount: this.transfer.amount,
                    originId: this.transfer.originId,
                    destinationId: this.transfer.destinationId,
                }
            },
            async getWallets() {
                await apiRouter.wallet.index().then((response) => {
                    this.wallets = response
                })
            },
            validateMovement() {
                let field = null
                if (! this.transfer.amount) {
                    field = 'valor'
                } else if (! this.transfer.originId || this.transfer.originId === 0) {
                    field = 'carteira de origem'
                } else if (! this.transfer.destinationId || this.transfer.destinationId === 0) {
                    field = 'carteira de destino'
                } else if (this.transfer.originId === this.transfer.destinationId) {
                    field = 'carteira de origem e destino'
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