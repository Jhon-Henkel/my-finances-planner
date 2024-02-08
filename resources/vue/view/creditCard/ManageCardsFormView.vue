<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <mfp-title :title="title" class="title"/>
            <divider/>
            <form class="was-validated text-black">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control"
                                   id="name-input"
                                   placeholder=""
                                   minlength="2"
                                   v-model="card.name"
                                   required>
                            <label for="name-input">Descrição</label>
                        </div>
                    </div>
                </div>
                <input-money :value="card.limit"
                             title="Limite"
                             @input-money="card.limit = $event"
                             :use-floating-labels="true"/>
                <div class="row justify-content-center mt-2">
                    <div class="col-4">
                        <div class="form-floating mb-3">
                            <input type="number"
                                   class="form-control"
                                   id="card-closing-day"
                                   placeholder=""
                                   v-model="card.closingDay"
                                   min="1"
                                   max="31"
                                   required>
                            <label for="card-closing-day">Dia Fechamento Fatura</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-4">
                        <div class="form-floating mb-3">
                            <input type="number"
                                   class="form-control"
                                   id="card-due-date"
                                   placeholder=""
                                   v-model="card.dueDate"
                                   min="1"
                                   max="31"
                                   required>
                            <label for="card-due-date">Dia Vencimento Fatura</label>
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <bottom-buttons redirect-to="/gerenciar-cartoes"
                            :button-success-text="title"
                            @btn-clicked="updateOrInsertCard"/>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import iconEnum from '~js/enums/iconEnum'
import apiRouter from '~js/router/apiRouter'
import InputMoney from '~vue-component/inputMoneyComponent.vue'
import { HttpStatusCode } from 'axios'
import BottomButtons from '~vue-component/BottomButtons.vue'
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import messageTools from '~js/tools/messageTools'

export default {
    name: 'ManageCardsFormView',
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
        InputMoney,
        LoadingComponent
    },
    data() {
        return {
            card: {},
            title: '',
            isValid: null,
            loadingDone: false,
            messageData: {}
        }
    },
    methods: {
        async updateOrInsertCard() {
            this.validateWallet()
            if (!this.isValid) {
                return
            }
            if (this.card.id) {
                await this.updateCard()
            } else {
                await this.insertCard()
            }
        },
        validateWallet() {
            let field = null
            if (!this.card.name || this.card.name.length < 2) {
                field = 'nome'
            } else if (!this.card.limit) {
                field = 'limite'
            } else if (!this.card.dueDate) {
                field = 'dia vencimento fatura'
            } else if (!this.card.closingDay) {
                field = 'dia fechamento fatura'
            }
            if (field) {
                this.messageData = messageTools.invalidFieldMessage(field)
                this.isValid = false
                return
            }
            this.isValid = true
        },
        async updateCard() {
            await apiRouter.cards.update(this.populateData(), this.card.id).then((response) => {
                if (response.status === HttpStatusCode.Ok) {
                    this.messageData = messageTools.successMessage('Cartão atualizado com sucesso!')
                    return
                }
                this.messageData = messageTools.errorMessage('Erro inesperado ao atualizar cartão!')
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
        async insertCard() {
            await apiRouter.cards.insert(this.populateData()).then((response) => {
                if (response.status === HttpStatusCode.Created) {
                    this.messageData = messageTools.successMessage('Cartão cadastrada com sucesso!')
                    this.card = {}
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao inserir cartão!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
        async getCard(cardId) {
            this.loadingDone = false
            this.card = await apiRouter.cards.show(cardId)
            this.loadingDone = true
        },
        populateData() {
            return {
                name: this.card.name,
                limit: this.card.limit,
                dueDate: this.card.dueDate,
                closingDay: this.card.closingDay
            }
        }
    },
    async mounted() {
        if (this.$route.params.id) {
            this.title = 'Atualizar Cartão'
            await this.getCard(this.$route.params.id)
            this.card.dueDate = parseInt(this.card.dueDate)
            this.card.closingDay = parseInt(this.card.closingDay)
        } else {
            this.title = 'Cadastrar Cartão'
            this.loadingDone = true
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