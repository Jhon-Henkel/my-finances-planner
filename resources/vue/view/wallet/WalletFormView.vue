<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <message :message="message" :type="messageType" v-show="message" :time="messageTimeOut"/>
            <h3 id="title">{{ title }}</h3>
            <hr class="mb-4">
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
                <input-money :value="wallet.amount" @input-money="updateWalletValueFromEvent"/>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group mt-2">
                            <label class="form-label" for="wallet-type">
                                Tipo de conta
                            </label>
                            <select class="form-select" v-model="wallet.type" id="wallet-type" required>
                                <option v-for="type in typesOfWallet" :key="type.id" :value="type.id">
                                    {{ type.description }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <hr class="mt-4">
            <bottom-buttons redirect-to="/carteiras" :button-success-text="title" @btn-clicked="updateOrInsertWallet"/>
        </div>
    </div>
</template>

<script>
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import calendarTools from "../../../js/tools/calendarTools";
    import messageEnum from "../../../js/enums/messageEnum";
    import walletEnum from "../../../js/enums/walletEnum";
    import apiRouter from "../../../js/router/apiRouter";
    import Message from "../../components/MessageComponent.vue";
    import {HttpStatusCode} from "axios";
    import iconEnum from "../../../js/enums/iconEnum";
    import InputMoney from "../../components/inputMoneyComponent.vue";
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import BottomButtons from "../../components/BottomButtons.vue";

    export default {
        name: "WalletFormView",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            BottomButtons,
            LoadingComponent,
            InputMoney,
            FontAwesomeIcon,
            Message
        },
        data() {
            return {
                idToUpdate: null,
                wallet: {},
                title: '',
                message: null,
                messageType: null,
                isValid: null,
                loadingDone: false,
                messageTimeOut: calendarTools.threeSecondsTimeInMs(),
                typesOfWallet: walletEnum.getIdAndDescriptionTypeList()
            }
        },
        methods: {
            // todo ambos os casos deve fazer redirect para a listagem e mostrar a mensagem de sucesso lá
            async updateOrInsertWallet() {
                this.validateWallet()
                if (! this.isValid) {
                    this.resetMessage()
                    return
                }
                if (this.wallet.id) {
                    await this.updateWallet()
                } else {
                    await this.insertWallet()
                }
            },
            validateWallet() {
                if (! this.wallet.name || this.wallet.name.length < 2) {
                    this.message = 'Campo "nome" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.wallet.amount) {
                    this.message = 'Campo "valor" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.wallet.type) {
                    this.message = 'Campo "tipo de conta" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
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
                await apiRouter.wallet.update(this.populateData(), this.wallet.id).then((response) => {
                    if (response.status === HttpStatusCode.Ok) {
                        this.message = 'Carteira atualizada com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao atualizar carteira!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })
            },
            async insertWallet() {
                await apiRouter.wallet.insert(this.populateData()).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.message = 'Carteira cadastrada com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.wallet = {}
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao inserir carteira!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })
            },
            resetMessage() {
                $(window).scrollTop(0, 0)
                setTimeout(() =>
                        [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            },
            updateWalletValueFromEvent(event) {
                this.wallet.amount = event
            }
        },
        async mounted() {
            if (this.$route.params.id) {
                this.title = 'Atualizar Carteira'
                this.wallet = await apiRouter.wallet.show(this.$route.params.id)
            } else {
                this.title = 'Cadastrar Carteira'
            }
        }
    }
</script>