<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <mfp-title :title="title" class="title"/>
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
                                   v-model="expense.name"
                                   required>
                            <label for="description-input">Descrição</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-4">
                        <div class="form-floating mb-3">
                            <input type="number"
                                   class="form-control"
                                   id="purchase-input"
                                   placeholder=""
                                   v-model="expense.nextInstallment"
                                   min="1"
                                   max="31"
                                   maxlength="2"
                                   required>
                            <label for="purchase-input">Dia da Compra</label>
                        </div>
                    </div>
                </div>
                <input-money :value="expense.value"
                             title="Valor Parcela"
                             @input-money="expense.value = $event"
                             :use-floating-labels="true"/>
                <div class="row justify-content-center mt-3">
                    <div class="col-4 text-white">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="fix-expense">
                                Despesa fixa
                            </label>
                            <input class="form-check-input"
                                   v-model="expense.fix"
                                   type="checkbox"
                                   role="switch"
                                   id="fix-expense">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3" v-if="expense.fix === false">
                    <div class="col-4">
                        <div class="form-floating mb-3">
                            <input type="number"
                                   class="form-control"
                                   id="expense-installments"
                                   placeholder=""
                                   v-model="expense.installments"
                                   min="1"
                                   max="48"
                                   required>
                            <label for="expense-installments">Parcelas restantes</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" :class="expense.fix ? 'mt-3' : 'mt-2'">
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-select" id="expense-credit-card" v-model="expense.creditCardId" required>
                                <option value="0" disabled>Selecione um cartão</option>
                                <option v-for="creditCard in creditCards" :key="creditCard.id" :value="creditCard.id">
                                    {{ creditCard.name }}
                                </option>
                            </select>
                            <label for="expense-credit-card">Cartão de crédito</label>
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <bottom-buttons :redirect-to="redirect" :button-success-text="title" @btn-clicked="updateOrInsertExpense"/>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import CalendarTools from '~js/tools/calendarTools'
import InputMoney from '../../../components/inputMoneyComponent.vue'
import apiRouter from '~js/router/apiRouter'
import iconEnum from '~js/enums/iconEnum'
import { HttpStatusCode } from 'axios'
import BottomButtons from '~vue-component/BottomButtons.vue'
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import messageTools from '~js/tools/messageTools'

const FIX_EXPENSE = 0

export default {
    name: 'CreditCardExpenseView',
    computed: {
        iconEnum() {
            return iconEnum
        },
        CalendarTools() {
            return CalendarTools
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
            expense: {
                creditCardId: 0,
                installments: 1,
                nextInstallment: new Date().getDate()
            },
            title: '',
            loadingDone: false,
            isValid: null,
            nextThreeMonthsWithYear: null,
            creditCards: {},
            redirect: '/gerenciar-cartoes',
            messageData: {}
        }
    },
    methods: {
        async updateOrInsertExpense() {
            this.validateExpense()
            if (!this.isValid) {
                return
            }
            if (this.expense.id) {
                await this.updateExpense()
            } else {
                await this.insertExpense()
            }
        },
        validateExpense() {
            let field = null
            if (!this.expense.name) {
                field = 'descrição'
            } else if (!this.expense.nextInstallment) {
                field = 'dia da compra'
            } else if (!this.expense.value || this.expense.value <= 0) {
                field = 'valor'
            } else if (this.expense.installments < 0 || this.expense.installments > 48) {
                field = 'parcelas restantes'
            } else if (!this.expense.creditCardId || this.expense.creditCardId <= 0) {
                field = 'cartão de credito'
            }
            if (field) {
                this.messageData = messageTools.invalidFieldMessage(field)
                this.isValid = false
                return
            }
            this.isValid = true
        },
        async insertExpense() {
            await apiRouter.expense.insert(this.populateExpense()).then((response) => {
                if (response.status === HttpStatusCode.Created) {
                    this.messageData = messageTools.successMessage('Despesa cadastrada com sucesso!')
                    this.expense = {}
                    this.expense.nextInstallment = CalendarTools.addDaysInDate(new Date(), 0)
                    this.expense.fix = false
                    if (this.$route.params.cardId) {
                        this.expense.creditCardId = this.$route.params.cardId
                    }
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao inserir despesa!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
        async updateExpense() {
            await apiRouter.expense.update(this.populateExpense(), this.expense.id).then((response) => {
                if (response.status === HttpStatusCode.Ok) {
                    this.card = {}
                    this.messageData = messageTools.successMessage('Despesa atualizada com sucesso!')
                } else {
                    this.messageData = messageTools.errorMessage('Erro inesperado ao atualizar despesa!')
                }
            }).catch((response) => {
                this.messageData = messageTools.errorMessage(response.response.data.error)
            })
        },
        async getExpense(expenseId) {
            this.loadingDone = false
            this.expense = await apiRouter.expense.show(expenseId)
            this.expense.nextInstallment = new Date(this.expense.nextInstallment).getDate()
            this.loadingDone = true
        },
        populateExpense() {
            let installmentsToPopulate = FIX_EXPENSE
            if (this.expense.fix === false) {
                installmentsToPopulate = this.expense.installments
            }
            const dateNextInstallment = new Date()
            dateNextInstallment.setDate(this.expense.nextInstallment)
            dateNextInstallment.toString().slice(0, 10)
            return {
                name: this.expense.name,
                installments: installmentsToPopulate,
                value: this.expense.value,
                creditCardId: this.expense.creditCardId,
                nextInstallment: dateNextInstallment
            }
        }
    },
    async mounted() {
        if (this.$route.params.id) {
            this.title = 'Atualizar Despesa'
            await this.getExpense(this.$route.params.id)
            if (this.expense.installments === FIX_EXPENSE) {
                this.expense.fix = true
            } else {
                this.expense.fix = false
            }
            this.redirect = '/gerenciar-cartoes/fatura-cartao/' + this.$route.params.id
        } else {
            this.title = 'Cadastrar Despesa'
            this.expense.fix = false
            this.loadingDone = true
        }
        this.nextThreeMonthsWithYear = CalendarTools.getNextThreeMonthsWithYear()
        this.creditCards = await apiRouter.cards.index()
        if (this.$route.params.cardId) {
            this.expense.creditCardId = this.$route.params.cardId
            this.redirect = '/gerenciar-cartoes/fatura-cartao/' + this.expense.creditCardId
        }
        if (!this.expense.nextInstallment) {
            this.expense.nextInstallment = CalendarTools.addDaysInDate(new Date(), 0)
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