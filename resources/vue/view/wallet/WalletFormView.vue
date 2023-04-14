<template>
    <!-- todo tooltip da página anterior não some -->
    <div class="base-container">
        <message :message="message" :type="messageType" v-show="message"/>
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
                        <input type="text" class="form-control" v-model="wallet.name" id="wallet-name" required>
                        <div class="invalid-feedback">
                            <span class="badge text-bg-danger">
                                Digite um nome válido
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- todo fazer mascara para o valor -->
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="form-group mt-2">
                        <label class="form-label" for="wallet-value">
                            Valor
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <font-awesome-icon :icon="['fas', 'brazilian-real-sign']" />
                            </span>
                            <input type="text"
                                   class="form-control"
                                   v-model="wallet.amount"
                                   maxlength="10"
                                   id="wallet-value"
                                   required>
                            <div class="invalid-feedback">
                                <span class="badge text-bg-danger">
                                    Digite um valor válido
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="form-group mt-2">
                        <label class="form-label" for="wallet-type">
                            Tipo de conta
                        </label>
                        <select class="form-control" v-model="wallet.type" id="wallet-type" required>
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
                <span class="material-symbols-outlined me-2">cancel</span>
                Cancelar
            </router-link>
            <button class="btn btn-success rounded-5 ms-3" @click="updateOrInsertWallet">
                <span class="material-symbols-outlined me-2">task_alt</span>
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
    import Message from "../../components/Message.vue";
    import {HttpStatusCode} from "axios";
    import router from "../../../js/router";

    export default {
        name: "WalletFormView",
        components: {FontAwesomeIcon, Message},
        data() {
            return {
                idToUpdate: null,
                wallet: {},
                title: '',
                message: null,
                messageType: null,
                typesOfWallet: walletEnum.getIdAndDescriptionTypeList()
            }
        },
        methods: {
            // todo ambos os casos deve fazer redirect para a listagem e mostrar a mensagem de sucesso lá
            // todo os time out deve ser responsabilidade do componente message
            async updateOrInsertWallet() {
                if (this.wallet.id) {
                    await this.updateWallet()
                } else {
                    await this.insertWallet()
                }
            },
            async updateWallet() {
                await apiRouter.wallet.update(this.wallet).then((response) => {
                    if (response.status === HttpStatusCode.Ok) {
                        this.message = 'Carteira atualizada com sucesso!'
                        this.messageType = messageEnum.messageSuccess()
                        setTimeout(() =>
                            [this.message = null, this.messageType = null, router.push({path: '/carteiras'})],
                            calendarTools.fiveSecondsTimeInMs()
                        )
                    } else {
                        this.message = 'Erro inesperado ao atualizar carteira!'
                        this.messageType = messageEnum.messageError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageError()
                })
            },
            async insertWallet() {
                await apiRouter.wallet.insert(this.wallet).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.message = 'Carteira cadastrada com sucesso!'
                        this.messageType = messageEnum.messageSuccess()
                        this.wallet = {}
                        setTimeout(() =>
                            [this.message = null, this.messageType = null],
                            calendarTools.fiveSecondsTimeInMs()
                        )
                    } else {
                        this.message = 'Erro inesperado ao inserir carteira!'
                        this.messageType = messageEnum.messageError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageError()
                })
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