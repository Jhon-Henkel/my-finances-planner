<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
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
            <div class="card glass success balance-card" v-if="! requestTools.device.isMobile()">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr>
                                        <th><font-awesome-icon :icon="iconEnum.calendarCheck()"/></th>
                                        <th scope="col">Descrição</th>
                                        <th scope="col" v-for="(month, index) in months" :key="index">
                                            {{ CalendarTools.getMonthNameByNumber(month) }}
                                        </th>
                                        <th scope="col">Restam</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center table-body-hover">
                                    <tr v-show="invoices.length === 0">
                                        <td colspan="9">Nenhuma despesa cadastrada ainda!</td>
                                    </tr>
                                    <tr v-for="expense in invoices" :key="expense.id">
                                        <td>{{ expense.nextInstallmentDay }}</td>
                                        <td>{{ expense.name }}</td>
                                        <td>{{ formatValueToBr(expense.firstInstallment) }}</td>
                                        <td>{{ formatValueToBr(expense.secondInstallment) }}</td>
                                        <td>{{ formatValueToBr(expense.thirdInstallment) }}</td>
                                        <td>{{ formatValueToBr(expense.fourthInstallment) }}</td>
                                        <td>{{ formatValueToBr(expense.fifthInstallment) }}</td>
                                        <td>{{ formatValueToBr(expense.sixthInstallment) }}</td>
                                        <td v-if="expense.remainingInstallments === 0" v-tooltip="'Despesa Fixa'">
                                            Fixo
                                        </td>
                                        <td v-else v-tooltip="formatValueToBr(expense.totalRemainingValue)">
                                            {{ expense.remainingInstallments }}
                                        </td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <div class="dropdown-center">
                                                <button class="btn btn-outline-success"
                                                        type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    <font-awesome-icon :icon="iconEnum.ellipsisVertical()"/>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button
                                                            class="dropdown-item"
                                                            @click="editExpense(expense)"
                                                            v-tooltip="'Editar'">
                                                            <font-awesome-icon :icon="iconEnum.editIcon()" />
                                                            Editar
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item"
                                                                @click="deleteExpense(expense.id, expense.name)"
                                                                v-tooltip="'Apagar'">
                                                            <font-awesome-icon :icon="iconEnum.trashIcon()" />
                                                            Apagar
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-table">
                                        <td colspan="2">Total</td>
                                        <td>{{ formatValueToBr(totalPerMonth.firstMonth) }}</td>
                                        <td>{{ formatValueToBr(totalPerMonth.secondMonth) }}</td>
                                        <td>{{ formatValueToBr(totalPerMonth.thirdMonth) }}</td>
                                        <td>{{ formatValueToBr(totalPerMonth.fourthMonth) }}</td>
                                        <td>{{ formatValueToBr(totalPerMonth.fifthMonth) }}</td>
                                        <td>{{ formatValueToBr(totalPerMonth.sixthMonth) }}</td>
                                        <td>{{ formatValueToBr(totalPerMonth.totalRemaining) }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card glass" v-else>
                <div class="mt-4 mb-4">
                    <div id="carouselExampleIndicators" class="carousel slide">
                        <div class="carousel-inner">
                            <mfp-invoice-carousel-item installment="firstInstallment"
                                                       :invoices="invoices"
                                                       :months="months"
                                                       :active="true"
                                                       @expense-edit="editExpense($event)"
                                                       @expense-delete="deleteExpense($event.id, $event.name)"/>
                            <mfp-invoice-carousel-item installment="secondInstallment"
                                                       :invoices="invoices"
                                                       :months="months"
                                                       @expense-edit="editExpense($event)"
                                                       @expense-delete="deleteExpense($event.id, $event.name)"/>
                            <mfp-invoice-carousel-item installment="thirdInstallment"
                                                       :invoices="invoices"
                                                       :months="months"
                                                       @expense-edit="editExpense($event)"
                                                       @expense-delete="deleteExpense($event.id, $event.name)"/>
                            <mfp-invoice-carousel-item installment="fourthInstallment"
                                                       :invoices="invoices"
                                                       :months="months"
                                                       @expense-edit="editExpense($event)"
                                                       @expense-delete="deleteExpense($event.id, $event.name)"/>
                            <mfp-invoice-carousel-item installment="fifthInstallment"
                                                       :invoices="invoices"
                                                       :months="months"
                                                       @expense-edit="editExpense($event)"
                                                       @expense-delete="deleteExpense($event.id, $event.name)"/>
                            <mfp-invoice-carousel-item installment="sixthInstallment"
                                                       :invoices="invoices"
                                                       :months="months"
                                                       @expense-edit="editExpense($event)"
                                                       @expense-delete="deleteExpense($event.id, $event.name)"/>
                        </div>
                        <button class="carousel-control-prev"
                                type="button"
                                data-bs-target="#carouselExampleIndicators"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next"
                                type="button"
                                data-bs-target="#carouselExampleIndicators"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            <divider/>
            <div>
                <div class="input-group mb-3">
                    <button class="btn btn-success show-pay-options"
                            :class="showPayInvoice ? '' : 'rounded-2'"
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
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import CalendarTools from '~js/tools/calendarTools'
import iconEnum from '~js/enums/iconEnum'
import apiRouter from '~js/router/apiRouter'
import StringTools from '~js/tools/stringTools'
import { HttpStatusCode } from 'axios'
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import NumberTools from '~js/tools/numberTools'
import RouterLinkButton from '~vue-component/RouterLinkButtonComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import MessageEnum from '~js/enums/messageEnum'
import messageTools from '~js/tools/messageTools'
import requestTools from '~js/tools/requestTools'
import MfpInvoiceCarouselItem from '~vue-component/carrousel/CarouselItemComponent.vue'
import Router from '~js/router'

export default {
    name: 'CreditCardInvoiceView',
    computed: {
        requestTools() {
            return requestTools
        },
        StringTools() {
            return StringTools
        },
        CalendarTools() {
            return CalendarTools
        },
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        MfpInvoiceCarouselItem,
        MfpMessage,
        RouterLinkButton,
        MfpTitle,
        Divider,
        LoadingComponent
    },
    data() {
        return {
            invoices: [],
            title: '',
            loadingDone: 0,
            walletId: 0,
            cardId: null,
            months: [],
            wallets: [],
            showPayInvoice: false,
            messageData: {},
            totalPerMonth: {
                firstMonth: 0,
                secondMonth: 0,
                thirdMonth: 0,
                fourthMonth: 0,
                fifthMonth: 0,
                sixthMonth: 0,
                totalRemaining: 0,
                total: 0
            }
        }
    },
    methods: {
        async deleteExpense(id, name) {
            if (confirm('Deseja realmente deletar a despesa ' + name + '?')) {
                await apiRouter.expense.delete(id)
                this.messageData = messageTools.successMessage('Despesa deletada com sucesso!')
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
                this.messageData = messageTools.errorMessage(error.response.data.message)
            })
        },
        calculateTotalPerMonth() {
            const totalPerMonthCount = NumberTools.calculateTotalPerMonthInvoiceItem(this.invoices)
            this.totalPerMonth.firstMonth = totalPerMonthCount.firstMonth
            this.totalPerMonth.secondMonth = totalPerMonthCount.secondMonth
            this.totalPerMonth.thirdMonth = totalPerMonthCount.thirdMonth
            this.totalPerMonth.fourthMonth = totalPerMonthCount.fourthMonth
            this.totalPerMonth.fifthMonth = totalPerMonthCount.fifthMonth
            this.totalPerMonth.sixthMonth = totalPerMonthCount.sixthMonth
            this.totalPerMonth.totalRemaining = totalPerMonthCount.totalRemaining
            this.totalPerMonth.total = totalPerMonthCount.total
        },
        editExpense(event) {
            Router.push('/gerenciar-cartoes/despesa/' + event.id + '/atualizar')
        },
        async payNextInvoice() {
            if (this.walletId === 0) {
                this.messageData = messageTools.newMessage(
                    MessageEnum.alertTypeInfo(),
                    'Você deve selecionar uma carteira!',
                    'Carteira não informada!'
                )
                return
            }
            if (confirm('Deseja realmente pagar a próxima fatura ?')) {
                await apiRouter.cards.invoices.payInvoice(this.walletId, this.cardId).then(async(response) => {
                    if (response.status !== HttpStatusCode.Ok) {
                        this.messageData = messageTools.errorMessage('Erro ao pagar fatura!')
                        return
                    }
                    this.messageData = messageTools.successMessage('Fatura paga com sucesso!')
                    this.showPayInvoice = false
                    await this.getInvoice()
                    this.walletId = 0
                }).catch(() => {
                    this.messageData = messageTools.errorMessage('Erro ao pagar fatura!')
                })
            }
        },
        formatValueToBr(value) {
            return StringTools.formatFloatValueToBrString(value)
        }
    },
    async mounted() {
        this.cardId = this.$route.params.id
        this.wallets = await apiRouter.wallet.index()
        this.card = await apiRouter.cards.show(this.cardId)
        await this.getInvoice()
        this.title = 'Fatura cartão ' + this.card.name
        this.months = CalendarTools.getNextSixMonths(CalendarTools.getThisMonth())
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
            width: 100% !important;
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