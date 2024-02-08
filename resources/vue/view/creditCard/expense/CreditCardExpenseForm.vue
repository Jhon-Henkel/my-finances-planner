<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <mfp-title :title="title" class="title"/>
            <divider/>
            <form class="was-validated">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="expense-name">
                                Descrição
                            </label>
                            <input type="text"
                                   class="form-control"
                                   v-model="expense.name"
                                   id="expense-name"
                                   required
                                   minlength="2">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="expense-first-installment">
                                Data da compra <br> (Formato: dia da compra, mês atual, ano atual)
                            </label>
                            <input type="date"
                                   class="form-control"
                                   v-model="expense.nextInstallment"
                                   id="expense-first-installment"
                                   required>
                        </div>
                    </div>
                </div>
                <input-money :value="expense.value" title="Valor Parcela" @input-money="expense.value = $event"/>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
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
                        <div class="form-group">
                            <label class="form-label" for="expense-installments">
                                Quantidade de vezes
                            </label>
                            <input type="number"
                                   class="form-control"
                                   v-model="expense.installments"
                                   id="expense-installments"
                                   required
                                   min="1"
                                   max="48">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" :class="expense.fix ? 'mt-3' : 'mt-2'">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="expense-credit-card">
                                Cartão de crédito
                            </label>
                            <select class="form-select" v-model="expense.creditCardId" id="expense-credit-card" required>
                                <option value="0" disabled>Selecione um cartão</option>
                                <option v-for="creditCard in creditCards" :key="creditCard.id" :value="creditCard.id">
                                    {{ creditCard.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <bottom-buttons :redirect-to="redirect"
                            :button-success-text="title"
                            @btn-clicked="updateOrInsertExpense"/>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '../../../components/LoadingComponent.vue'
import CalendarTools from '../../../../js/tools/calendarTools'
import InputMoney from '../../../components/inputMoneyComponent.vue'
import apiRouter from '../../../../js/router/apiRouter'
import iconEnum from '../../../../js/enums/iconEnum'
import { HttpStatusCode } from 'axios'
import BottomButtons from '../../../components/BottomButtons.vue'
import Divider from '../../../components/DividerComponent.vue'
import MfpTitle from '../../../components/TitleComponent.vue'
import MfpMessage from '../../../components/MessageAlert.vue'
import messageTools from '../../../../js/tools/messageTools'

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
                creditCardId: 0
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
                field = 'data da compra'
            } else if (!this.expense.value || this.expense.value <= 0) {
                field = 'valor'
            } else if (this.expense.installments < 0 || this.expense.installments > 48) {
                field = 'quantidade de vezes'
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
            this.loadingDone = true
        },
        populateExpense() {
            let installmentsToPopulate = FIX_EXPENSE
            if (this.expense.fix === false) {
                installmentsToPopulate = this.expense.installments
            }
            return {
                name: this.expense.name,
                installments: installmentsToPopulate,
                value: this.expense.value,
                creditCardId: this.expense.creditCardId,
                nextInstallment: this.expense.nextInstallment
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
            this.redirect = '/gerenciar-cartoes/fatura-cartao/' + this.expense.creditCardId
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