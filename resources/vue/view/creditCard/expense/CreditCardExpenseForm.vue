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
                                Primeira Parcela
                            </label>
                            <select class="form-select"
                                    v-model="expense.nextInstallment"
                                    id="expense-first-installment"
                                    required>
                                <option v-for="(date, index) in nextThreeMonthsWithYear"
                                        :key="index"
                                        :value="date.year + '-' + date.month">
                                    {{ CalendarTools.getMonthNameByNumber(date.month) + ' - ' + date.year }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <input-money :value="expense.value" @input-money="updateExpenseValueFromEvent"/>
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
                            <select class="form-select"
                                    v-model="expense.creditCardId"
                                    id="expense-credit-card"
                                    required>
                                <option v-for="creditCard in creditCards"
                                        :key="creditCard.id"
                                        :value="creditCard.id">
                                    {{ creditCard.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <hr class="mt-4">
            <!-- todo redirect deve ser para a tela que chamou, sendo a de faturas ou a de gerenciar cartões -->
            <bottom-buttons redirect-to="/gerenciar-cartoes"
                            :button-success-text="title"
                            @btn-clicked="updateOrInsertExpense"/>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../../components/LoadingComponent.vue";
    import Message from "../../../components/MessageComponent.vue";
    import calendarTools from "../../../../js/tools/calendarTools";
    import CalendarTools from "../../../../js/tools/calendarTools";
    import InputMoney from "../../../components/inputMoneyComponent.vue";
    import apiRouter from "../../../../js/router/apiRouter";
    import iconEnum from "../../../../js/enums/iconEnum";
    import messageEnum from "../../../../js/enums/messageEnum";
    import {HttpStatusCode} from "axios";
    import BottomButtons from "../../../components/BottomButtons.vue";

    const FIX_EXPENSE = 0

    export default {
        name: "CreditCardExpenseView",
        computed: {
            iconEnum() {
                return iconEnum
            },
            CalendarTools() {
                return CalendarTools
            }
        },
        components: {
            BottomButtons,
            InputMoney,
            Message,
            LoadingComponent
        },
        data() {
            return {
                expense: {},
                title: '',
                message: null,
                messageType: null,
                loadingDone: false,
                isValid: null,
                messageTimeOut: calendarTools.threeSecondsTimeInMs(),
                nextThreeMonthsWithYear: null,
                creditCards: {}
            }
        },
        methods: {
            resetMessage() {
                setTimeout(() =>
                    [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            },
            updateExpenseValueFromEvent(value) {
                this.expense.value = value
            },
            async updateOrInsertExpense() {
                this.validateExpense()
                if (! this.isValid) {
                    this.resetMessage()
                    return
                }
                if (this.expense.id) {
                    await this.updateExpense()
                } else {
                    await this.insertExpense()
                }
            },
            validateExpense() {
                if (! this.expense.name) {
                    this.message = 'Campo "Descrição" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.expense.nextInstallment) {
                    this.message = 'Campo "Primeira parcela" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.expense.value || this.expense.value <= 0) {
                    this.message = 'Campo "Valor" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (this.expense.installments < 0 || this.expense.installments > 48) {
                    this.message = 'Campo "Quantidade de vezes" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                if (! this.expense.creditCardId) {
                    this.message = 'Campo "Cartão de crédito" é inválido!'
                    this.messageType = messageEnum.messageTypeWarning()
                    this.isValid = false
                    return
                }
                this.isValid = true
            },
            async insertExpense() {
                await apiRouter.expense.insert(this.populateExpense()).then((response) => {
                    if (response.status === HttpStatusCode.Created) {
                        this.message = 'Despesa cadastrada com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.card = {}
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao inserir despesa!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })
            },
            async updateExpense() {
                await apiRouter.expense.update(this.populateExpense(), this.expense.id).then((response) => {
                    if (response.status === HttpStatusCode.Ok) {
                        this.message = 'Despesa atualizar com sucesso!'
                        this.messageType = messageEnum.messageTypeSuccess()
                        this.card = {}
                        this.resetMessage()
                    } else {
                        this.message = 'Erro inesperado ao atualizar despesa!'
                        this.messageType = messageEnum.messageTypeError()
                    }
                }).catch((response) => {
                    this.message = response.response.data.error
                    this.messageType = messageEnum.messageTypeError()
                })
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
                    nextInstallment: this.expense.nextInstallment,
                }
            }
        },
        async mounted() {
            if (this.$route.params.id) {
                this.title = 'Atualizar Despesa'
                this.expense = await apiRouter.expense.show(this.$route.params.id)
                if (this.expense.installments === FIX_EXPENSE) {
                    this.expense.fix = true
                }
            } else {
                this.title = 'Cadastrar Despesa'
                this.expense.fix = false
            }
            this.nextThreeMonthsWithYear = CalendarTools.getNextThreeMonthsWithYear()
            this.creditCards = await apiRouter.cards.index()
        }
    }
</script>