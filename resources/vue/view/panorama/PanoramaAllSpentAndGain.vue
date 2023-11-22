<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone < 4"/>
        <div v-show="loadingDone >= 4">
            <div class="nav justify-content-end">
                <mfp-title title="Gerenciar despesas e ganhos" class="title"/>
                <back-button to="/panorama" class="top-button"/>
            </div>
            <divider/>
            <div class="card glass success balance-card">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <td colspan="11" class="border-table">
                                            <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="spent-icon me-2"/>
                                            Todas as Despesas (Exceto Cartões)
                                        </td>
                                    </tr>
                                    <tr class="text-center border-table">
                                        <td>Nome Carteira</td>
                                        <td>Descrição</td>
                                        <td>Valor</td>
                                        <td>Parcelas</td>
                                        <td>Próximo Vencimento</td>
                                        <td>Valor Total</td>
                                        <td>Ações</td>
                                    </tr>
                                </thead>
                                <tbody class="table-body-hover">
                                    <tr v-for="spent in spending" class="text-center">
                                        <td>{{ spent.walletName }}</td>
                                        <td>{{ spent.description }}</td>
                                        <td>{{ stringTools.formatFloatValueToBrString(spent.amount) }}</td>
                                        <td>{{ spent.installments === 0 ? 'Fixo' : spent.installments }}</td>
                                        <td>{{ calendarTools.convertDateDbToBr(spent.forecast, false) }}</td>
                                        <td>{{ stringTools.formatFloatValueToBrString(spent.amount * spent.installments) }}</td>
                                        <td>
                                            <action-buttons
                                                :delete-tooltip="'Deletar Despesa'"
                                                :tooltip-edit="'Editar Despesa'"
                                                :edit-to="'/panorama/' + spent.id + '/atualizar-despesa?referer=' + referer"
                                                @delete-clicked="deleteSpent(spent.id, spent.description)" />
                                        </td>
                                    </tr>
                                    <tr class="border-table-top">
                                        <td colspan="4">Total (Se fixo, considera uma parcela)</td>
                                        <td colspan="3">{{ stringTools.formatFloatValueToBrString(totalSpent) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card glass success balance-card mt-4">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <td colspan="11" class="border-table">
                                            <font-awesome-icon :icon="iconEnum.circleArrowUp()" class="gain-icon me-2"/>
                                            Todos os Ganhos
                                        </td>
                                    </tr>
                                    <tr class="text-center border-table">
                                        <td>Nome Carteira</td>
                                        <td>Descrição</td>
                                        <td>Valor</td>
                                        <td>Parcelas</td>
                                        <td>Próximo Vencimento</td>
                                        <td>Valor Total</td>
                                        <td>Ações</td>
                                    </tr>
                                </thead>
                                <tbody class="table-body-hover">
                                    <tr v-for="gain in gains" :key="gain.id" class="text-center">
                                        <td>{{ gain.walletName }}</td>
                                        <td>{{ gain.description }}</td>
                                        <td>{{ stringTools.formatFloatValueToBrString(gain.amount) }}</td>
                                        <td>{{ gain.installments === 0 ? 'Fixo' : gain.installments }}</td>
                                        <td>{{ calendarTools.convertDateDbToBr(gain.forecast, false) }}</td>
                                        <td>{{ stringTools.formatFloatValueToBrString(gain.amount * gain.installments) }}</td>
                                        <td>
                                            <action-buttons
                                                :delete-tooltip="'Deletar Ganho'"
                                                :tooltip-edit="'Editar Ganho'"
                                                :edit-to="'/ganhos-futuros/' + gain.id + '/atualizar?referer=' + referer"
                                                @delete-clicked="deleteGain(gain.id, gain.description)" />
                                        </td>
                                    </tr>
                                    <tr class="border-table-top">
                                        <td colspan="4">Total (Se fixo, considera uma parcela)</td>
                                        <td colspan="3">{{ stringTools.formatFloatValueToBrString(totalGain) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card glass success balance-card mt-4">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                <tr class="text-center">
                                    <td colspan="11" class="border-table">
                                        <font-awesome-icon :icon="iconEnum.creditCard()" class="spent-icon me-2"/>
                                        Gastos Cartão de Crédito
                                    </td>
                                </tr>
                                <tr class="text-center border-table">
                                    <td>Nome Cartão</td>
                                    <td>Descrição</td>
                                    <td>Valor</td>
                                    <td>Parcelas</td>
                                    <td>Próximo Vencimento</td>
                                    <td>Valor Total</td>
                                    <td>Ações</td>
                                </tr>
                                </thead>
                                <tbody class="table-body-hover">
                                <tr v-for="creditCardSpent in creditCardTransactions" :key="creditCardSpent.id" class="text-center">
                                    <td>{{ creditCardSpent.creditCardId }}</td>
                                    <td>{{ creditCardSpent.name }}</td>
                                    <td>{{ stringTools.formatFloatValueToBrString(creditCardSpent.value) }}</td>
                                    <td>{{ creditCardSpent.installments === 0 ? 'Fixo' : creditCardSpent.installments }}</td>
                                    <td>{{ calendarTools.convertDateDbToBr(creditCardSpent.nextInstallment, false) }}</td>
                                    <td>{{ stringTools.formatFloatValueToBrString(creditCardSpent.value * creditCardSpent.installments) }}</td>
                                    <td>
                                        <action-buttons
                                            delete-tooltip="Deletar Despesa Cartão"
                                            tooltip-edit="Editar Despesa Cartão"
                                            :edit-to="'/gerenciar-cartoes/despesa/' + creditCardSpent.id + '/atualizar'"
                                            @delete-clicked="deleteCreditCardExpense(creditCardSpent.id, creditCardSpent.description)" />
                                    </td>
                                </tr>
                                <tr class="border-table-top">
                                    <td colspan="4">Total (Se fixo, considera uma parcela)</td>
                                    <td colspan="3">{{ stringTools.formatFloatValueToBrString(totalCreditCardExpense) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <divider/>
        </div>
    </div>
</template>

<script>
import MfpMessage from '../../components/MessageAlert.vue'
import LoadingComponent from '../../components/LoadingComponent.vue'
import MfpTitle from '../../components/TitleComponent.vue'
import Divider from '../../components/DividerComponent.vue'
import iconEnum from '../../../js/enums/iconEnum'
import ApiRouter from '../../../js/router/apiRouter'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import stringTools from '../../../js/tools/stringTools'
import ActionButtons from '../../components/ActionButtons.vue'
import calendarTools from '../../../js/tools/calendarTools'
import BackButton from '../../components/buttons/BackButton.vue'
import messageTools from '../../../js/tools/messageTools'

export default {
    name: 'PanoramaAllSpentAndGain',
    computed: {
        calendarTools() {
            return calendarTools
        },
        stringTools() {
            return stringTools
        },
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        BackButton,
        ActionButtons,
        FontAwesomeIcon,
        Divider,
        MfpTitle,
        LoadingComponent,
        MfpMessage
    },
    data() {
        return {
            loadingDone: 0,
            gains: {},
            spending: {},
            referer: 'panorama/todas-despesas-e-ganhos',
            messageData: {},
            creditCardTransactions: {},
            creditCards: {},
            totalSpent: 0,
            totalGain: 0,
            totalCreditCardExpense: 0
        }
    },
    methods: {
        async getAllSpending() {
            await ApiRouter.futureSpent.index().then(response => {
                this.spending = response
                this.spending.forEach(spent => {
                    const installments = spent.installments === 0 ? 1 : spent.installments
                    this.totalSpent += spent.amount * installments
                })
            }).catch(error => {
                this.messageData = messageTools.errorMessage(error.response.data.message)
            })
            this.loadingDone = this.loadingDone + 1
        },
        async getAllGains() {
            await ApiRouter.futureGain.index().then(response => {
                this.gains = response
                this.gains.forEach(gain => {
                    const installments = gain.installments === 0 ? 1 : gain.installments
                    this.totalGain += gain.amount * installments
                })
            }).catch(error => {
                this.messageData = messageTools.errorMessage(error.response.data.message)
            })
            this.loadingDone = this.loadingDone + 1
        },
        async getAllCreditCardSpending() {
            await ApiRouter.expense.index().then(response => {
                this.creditCardTransactions = response
                this.creditCardTransactions.forEach(creditCardTransaction => {
                    this.creditCards.forEach(creditCard => {
                        if (creditCardTransaction.creditCardId === creditCard.id) {
                            creditCardTransaction.creditCardId = creditCard.name
                        }
                    })
                    const installments = creditCardTransaction.installments === 0 ? 1 : creditCardTransaction.installments
                    this.totalCreditCardExpense += creditCardTransaction.value * installments
                })
            }).catch(error => {
                this.messageData = messageTools.errorMessage(error.response.data.message)
            })
            this.loadingDone = this.loadingDone + 1
        },
        async getAllCreditCards() {
            await ApiRouter.cards.index().then(response => {
                this.creditCards = response
            }).catch(error => {
                this.messageData = messageTools.errorMessage(error.response.data.message)
            })
            this.loadingDone = this.loadingDone + 1
        },
        async deleteSpent(id, spentName) {
            if (confirm('Tem certeza que realmente quer deletar a despesa ' + spentName + '?')) {
                await ApiRouter.futureSpent.delete(id).then(() => {
                    this.messageData = messageTools.successMessage('Despesa deletada com sucesso!')
                    this.getAllSpending()
                }).catch(() => {
                    this.messageData = messageTools.errorMessage('Não foi possível deletar a despesa!')
                })
            }
        },
        async deleteGain(id, gainName) {
            if (confirm('Tem certeza que realmente quer deletar o ganho ' + gainName + '?')) {
                await ApiRouter.futureGain.delete(id).then(() => {
                    this.messageData = messageTools.successMessage('Ganho deletado com sucesso!')
                    this.getAllGains()
                }).catch(() => {
                    this.messageData = messageTools.errorMessage('Não foi possível deletar o ganho!')
                })
            }
        },
        async deleteCreditCardExpense(id, creditCardExpenseName) {
            if (confirm('Tem certeza que realmente quer deletar o ganho ' + creditCardExpenseName + '?')) {
                await ApiRouter.expense.delete(id).then(() => {
                    this.messageData = messageTools.successMessage('Despesa cartão deletada com sucesso!')
                    this.getAllCreditCardSpending()
                }).catch(() => {
                    this.messageData = messageTools.errorMessage('Não foi possível deletar o despesa cartão!')
                })
            }
        }
    },
    mounted() {
        this.getAllCreditCards().then(() => {
            this.getAllCreditCardSpending()
        })
        this.getAllSpending()
        this.getAllGains()
    }
}
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .gain-icon {
        color: $success-icon-color;
    }
    .spent-icon {
        color: $danger-icon-color;
    }
    .border-table {
        border-bottom: 2px solid $table-line-divider-color;
    }
    .border-table-top {
        border-top: 2px solid $table-line-divider-color;
    }
    @media (max-width: 1000px) {
        .title {
            margin: auto auto auto 75px !important;
        }
        .nav {
            flex-direction: column;
        }
        .top-button {
            margin-top: 10px;
            border-radius: 8px !important;
        }
    }
</style>