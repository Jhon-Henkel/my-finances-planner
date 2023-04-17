<template>
    <div class="base-container">
        <message :message="message" :type="messageType" v-show="message" :time="messageTimeOut"/>
        <div>
            <h3 id="title">{{ title }}</h3>
        </div>
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
                        <div class="invalid-feedback">
                            <span class="badge text-bg-danger">
                                Digite um nome válido
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="form-group mt-2">
                        <input-money :value="wallet.amount" @input-money="updateWalletValueFromEvent"></input-money>
                    </div>
                </div>
            </div>
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
                        <div class="invalid-feedback">
                            <span class="badge text-bg-danger">
                                Selecione uma opção válida
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="mt-4">
        <div class="nav justify-content-center">
            <router-link class="btn btn-danger rounded-5" to="/carteiras">
                <font-awesome-icon :icon="iconEnum.xMark()" class="me-2"/>
                Cancelar
            </router-link>
            <button class="btn btn-success rounded-5 ms-3" @click="updateOrInsertWallet">
                <font-awesome-icon :icon="iconEnum.check()" class="me-2" />
                {{ title }}
            </button>
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

    export default {
        name: "WalletFormView",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {
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
                    this.message = 'Campo nome é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.wallet.amount) {
                    this.message = 'Campo valor é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.wallet.type) {
                    this.message = 'Campo tipo de conta é inválido!'
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

<style scoped>

</style>