<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === 0" />
        <div v-show="loadingDone === 1">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="title"/>
                <router-link-button title="Voltar" :icon="iconEnum.back()"
                                    redirect-to="/gerenciar-cartoes"
                                    class="top-button"/>
                <router-link-button title="Nova despesa"
                                    :icon="iconEnum.expense()"
                                    :redirect-to="'/gerenciar-cartoes/despesa/' + cardId + '/cadastrar'"
                                    class="ms-2 top-button"/>
            </div>
            <divider/>
            <div class="table-responsive-lg">
                <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col" v-for="(month, index) in months" :key="index">
                                {{ calendarTools.getMonthNameByNumber(month) }}
                            </th>
                            <th scope="col">Restam</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-show="invoices.length === 0">
                            <td colspan="9">Nenhuma despesa cadastrada ainda!</td>
                        </tr>
                        <tr v-for="expense in invoices" :key="expense.id">
                            <td>{{ expense.name }}</td>
                            <td>{{ formatValueToBr(expense.firstInstallment) }}</td>
                            <td>{{ formatValueToBr(expense.secondInstallment) }}</td>
                            <td>{{ formatValueToBr(expense.thirdInstallment) }}</td>
                            <td>{{ formatValueToBr(expense.forthInstallment) }}</td>
                            <td>{{ formatValueToBr(expense.fifthInstallment) }}</td>
                            <td>{{ formatValueToBr(expense.sixthInstallment) }}</td>
                            <td v-if="expense.remainingInstallments === 0" v-tooltip="'Despesa Fixa'">Fixo</td>
                            <td v-else v-tooltip="formatValueToBr(expense.totalRemainingValue)">
                                {{ expense.remainingInstallments }}
                            </td>
                            <td>
                                <action-buttons :delete-tooltip="'Deletar Fatura'"
                                                :tooltip-edit="'Editar Fatura'"
                                                :edit-to="'/gerenciar-cartoes/despesa/' + expense.id + '/atualizar'"
                                                @delete-clicked="deleteExpense(expense.id, expense.name)"/>
                            </td>
                        </tr>
                        <tr class="border-table">
                            <td>Total</td>
                            <td>{{ formatValueToBr(totalPerMonth.firstMonth) }}</td>
                            <td>{{ formatValueToBr(totalPerMonth.secondMonth) }}</td>
                            <td>{{ formatValueToBr(totalPerMonth.thirdMonth) }}</td>
                            <td>{{ formatValueToBr(totalPerMonth.forthMonth) }}</td>
                            <td>{{ formatValueToBr(totalPerMonth.fifthMonth) }}</td>
                            <td>{{ formatValueToBr(totalPerMonth.sixthMonth) }}</td>
                            <td>{{ formatValueToBr(totalPerMonth.totalRemaining) }}</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <divider/>
            <div>
                <div class="input-group mb-3">
                    <button class="btn btn-success show-pay-options"
                            :class="showPayInvoice ? '' : 'rounded-5'"
                            @click="showPayInvoice = !showPayInvoice">
                        <font-awesome-icon :icon="iconEnum.paying()" class="me-2"/>
                        Pagar próxima fatura
                    </button>
                    <select class="form-select" id="pay-invoice" v-model="walletId" v-show="showPayInvoice" required>
                        <option value="0" disabled>Selecione a carteira</option>
                        <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id" @change="walletId = $event">
                            {{ wallet.name }}
                        </option>
                    </select>
                    <button class="btn btn-success pay-button" type="button" v-show="showPayInvoice" @click="payNextInvoice">
                        <font-awesome-icon :icon="iconEnum.check()" class="me-2"/>
                        Pagar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../../components/LoadingComponent.vue";
    import CalendarTools from "../../../../js/tools/calendarTools";
    import iconEnum from "../../../../js/enums/iconEnum";
    import apiRouter from "../../../../js/router/apiRouter";
    import calendarTools from "../../../../js/tools/calendarTools";
    import StringTools from "../../../../js/tools/stringTools";
    import ActionButtons from "../../../components/ActionButtons.vue";
    import {HttpStatusCode} from "axios";
    import Divider from "../../../components/DividerComponent.vue";
    import MfpTitle from "../../../components/TitleComponent.vue";
    import NumberTools from "../../../../js/tools/numberTools";
    import RouterLinkButton from "../../../components/RouterLinkButtonComponent.vue";
    import MfpMessage from "../../../components/MessageAlert.vue";
    import MessageEnum from "../../../../js/enums/messageEnum";

    export default {
        name: "CreditCardInvoiceView",
        computed: {
            StringTools() {
                return StringTools
            },
            calendarTools() {
                return calendarTools
            },
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            MfpMessage,
            RouterLinkButton,
            MfpTitle,
            Divider,
            ActionButtons,
            LoadingComponent,
        },
        data() {
            return {
                invoices: {},
                title: '',
                loadingDone: 0,
                walletId: 0,
                thisMonth: null,
                cardId: null,
                months: [],
                wallets:{},
                showPayInvoice: false,
                totalPerMonth: {
                    firstMonth: 0,
                    secondMonth: 0,
                    thirdMonth: 0,
                    forthMonth: 0,
                    fifthMonth: 0,
                    sixthMonth: 0,
                    totalRemaining: 0,
                    total: 0
                },
            }
        },
        methods: {
            messageError(message) {
                this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
            },
            messageSuccess(message) {
                this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
            },
            showMessage(type, message, title) {
                this.$refs.message.showAlert(type, message, title)
            },
            async deleteExpense(id, name) {
                if (confirm('Deseja realmente deletar a despesa ' + name + '?')) {
                    await apiRouter.expense.delete(id)
                    this.messageSuccess('Despesa deletada com sucesso!')
                    await this.getInvoice()
                }
            },
            async getInvoice() {
                this.loadingDone = 0
                await apiRouter.cards.invoices.index(this.cardId).then(response => {
                    this.invoices = response
                    this.loadingDone++
                    this.calculateTotalPerMonth()
                }).catch(error => {
                    this.messageError(error.response.data.message)
                })
            },
            calculateTotalPerMonth() {
                let totalPerMonthCount = NumberTools.calculateTotalPerMonthInvoiceItem(this.invoices)
                this.totalPerMonth.firstMonth = totalPerMonthCount.firstMonth
                this.totalPerMonth.secondMonth = totalPerMonthCount.secondMonth
                this.totalPerMonth.thirdMonth = totalPerMonthCount.thirdMonth
                this.totalPerMonth.forthMonth = totalPerMonthCount.forthMonth
                this.totalPerMonth.fifthMonth = totalPerMonthCount.fifthMonth
                this.totalPerMonth.sixthMonth = totalPerMonthCount.sixthMonth
                this.totalPerMonth.totalRemaining = totalPerMonthCount.totalRemaining
                this.totalPerMonth.total = totalPerMonthCount.total
            },
            async payNextInvoice() {
                if (this.walletId === 0) {
                    this.showMessage(
                        MessageEnum.alertTypeInfo(),
                        'Você deve selecionar uma carteira!',
                        'Carteira não informada!'
                    )
                    return
                }
                if (confirm('Deseja realmente pagar a próxima fatura ?')) {
                    await apiRouter.cards.invoices.payInvoice(this.walletId, this.cardId).then(async (response) => {
                        if (response.status !== HttpStatusCode.Ok) {
                            this.messageError('Erro ao pagar fatura!')
                            return
                        }
                        this.messageSuccess('Fatura paga com sucesso!')
                        this.showPayInvoice = false
                        await this.getInvoice()
                        this.walletId = 0
                    }).catch(() => {
                        this.messageError('Erro ao pagar fatura!')
                    })
                }
            },
            formatValueToBr(value) {
                return StringTools.formatFloatValueToBrString(value)
            },
        },
        async mounted() {
            this.cardId = this.$route.params.id
            this.wallets = await apiRouter.wallet.index()
            this.card = await apiRouter.cards.show(this.cardId)
            await this.getInvoice()
            this.title = 'Fatura cartão ' + this.card.name
            this.thisMonth = CalendarTools.getThisMonth()
            this.months = CalendarTools.getNextSixMonths(this.thisMonth)
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../../../sass/variables";

    .border-table {
        border-top: 2px solid $table-line-divider-color;
    }
    @media (max-width: 1000px) {
        .nav {
            flex-direction: column;
        }
        .top-button {
            margin-top: 10px;
            border-radius: 8px !important;
        }
        .ms-2 {
            margin-left: 0 !important;
        }
        .input-group {
            flex-direction: column;
        }
        .form-select {
            margin-bottom: 10px;
            width: 100%;
            border-radius: 8px !important;
        }
        .pay-button,
        .show-pay-options {
            width: 100%;
            border-radius: 8px !important;
        }
        .show-pay-options {
            margin-bottom: 10px;
        }
    }
</style>