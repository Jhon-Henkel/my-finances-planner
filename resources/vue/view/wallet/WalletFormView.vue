<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <mfp-title :title="title" class="title"/>
            <divider/>
            <form class="was-validated">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="wallet-name">
                                Nome
                            </label>
                            <input type="text"
                                   class="form-control"
                                   v-model="wallet.name"
                                   id="wallet-name"
                                   required
                                   minlength="2">
                        </div>
                    </div>
                </div>
                <input-money :value="wallet.amount" @input-money="wallet.amount = $event"/>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group mt-2">
                            <label class="form-label" for="wallet-type">
                                Tipo de conta
                            </label>
                            <select class="form-select" v-model="wallet.type" id="wallet-type" required>
                                <option value="0" disabled selected>Selecione um tipo de conta</option>
                                <option v-for="type in typesOfWallet" :key="type.id" :value="type.id">
                                    {{ type.description }}
                                </option>
                            </select>
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
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import messageEnum from "../../../js/enums/messageEnum";
    import walletEnum from "../../../js/enums/walletEnum";
    import apiRouter from "../../../js/router/apiRouter";
    import {HttpStatusCode} from "axios";
    import iconEnum from "../../../js/enums/iconEnum";
    import InputMoney from "../../components/inputMoneyComponent.vue";
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import BottomButtons from "../../components/BottomButtons.vue";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import MfpMessage from "../../components/MessageAlert.vue";
    import MessageEnum from "../../../js/enums/messageEnum";
    import stringTools from "../../../js/tools/stringTools";

    export default {
        name: "WalletFormView",
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
            InputMoney,
            FontAwesomeIcon,
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
                typesOfWallet: walletEnum.getIdAndDescriptionTypeList()
            }
        },
        methods: {
            async updateOrInsertWallet() {
                this.validateWallet()
                if (! this.isValid) {
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
                if (! this.wallet.name || this.wallet.name.length < 2) {
                    field = 'nome'
                } else if (this.wallet.type < 0 || this.wallet.type > 10) {
                    field = 'tipo de conta'
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
            populateData() {
                return {
                    name: this.wallet.name,
                    type: this.wallet.type,
                    amount: this.wallet.amount
                }
            },
            async updateWallet() {
                if (
                    confirm('Deseja realmente atualizar a carteira "'
                    + this.wallet.name + '" com o valor "'
                    + stringTools.formatFloatValueToBrString(this.wallet.amount)
                    + '" ?') === false
                ) {
                    return
                }
                await apiRouter.wallet.update(this.populateData(), this.wallet.id).then((response) => {
                    if (response.status === HttpStatusCode.Ok) {
                        this.messageSuccess('Carteira atualizada com sucesso!')
                    } else {
                        this.messageError('Erro inesperado ao atualizar carteira!')
                    }
                }).catch((response) => {
                    this.messageError(response.response.data.error)
                })
            },
            async insertWallet() {
                await apiRouter.wallet.insert(this.populateData()).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.messageSuccess('Carteira cadastrada com sucesso!')
                        this.wallet = {}
                    } else {
                        this.messageError('Erro inesperado ao inserir carteira!')
                    }
                }).catch((response) => {
                    this.messageError(response.response.data.error)
                })
            },
            messageError(message) {
                this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
            },
            messageSuccess(message) {
                this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
            },
            showMessage(type, message, header) {
                this.$refs.message.showAlert(type,message,header)
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