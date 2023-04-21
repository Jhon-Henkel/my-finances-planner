<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <message :message="message" :type="messageType" v-show="message" :time="messageTimeOut"/>
            <div class="nav mt-2 justify-content-end">
                <h3 id="title">{{ title }}</h3>
                <router-link class="btn btn-success rounded-5" to="/gerenciar-cartoes/despesa/cadastrar">
                    <font-awesome-icon :icon="iconEnum.expense()" class="me-2"/>
                    Nova despesa
                </router-link>
            </div>
            <hr class="mb-4">
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                <tr>
                    <th class="text-center" scope="col">Descrição</th>
                    <th class="text-center" scope="col" v-for="(month, index) in months" :key="index">
                        {{ calendarTools.getMonthNameByNumber(month) }}
                    </th>
                    <th class="text-center" scope="col">Restam</th>
                    <th class="text-center" scope="col">Valor restante</th>
                    <th class="text-center" scope="col">Ações</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="expense in invoices" :key="expense.id">
                        <td class="text-center">{{ expense.name }}</td>
                        <td class="text-center">
                            {{
                                expense.firstInstallment
                                    ? StringTools.formatFloatValueToBrString(expense.firstInstallment)
                                    : '-'
                            }}
                        </td>
                        <td class="text-center">
                            {{
                                expense.secondInstallment
                                    ? StringTools.formatFloatValueToBrString(expense.secondInstallment)
                                    : '-'
                            }}
                        </td>
                        <td class="text-center">
                            {{
                                expense.thirdInstallment
                                    ? StringTools.formatFloatValueToBrString(expense.thirdInstallment)
                                    : '-'
                            }}
                        </td>
                        <td class="text-center">
                            {{
                                expense.forthInstallment
                                    ? StringTools.formatFloatValueToBrString(expense.forthInstallment)
                                    : '-'
                            }}
                        </td>
                        <td class="text-center">
                            {{
                                expense.fifthInstallment
                                    ? StringTools.formatFloatValueToBrString(expense.fifthInstallment)
                                    : '-'
                            }}
                        </td>
                        <td class="text-center">
                            {{
                                expense.sixthInstallment
                                    ? StringTools.formatFloatValueToBrString(expense.sixthInstallment)
                                    : '-'
                            }}
                        </td>
                        <td class="text-center">{{ expense.remainingInstallments + ' Parcelas' }}</td>
                        <td class="text-center">
                            {{ StringTools.formatFloatValueToBrString(expense.totalRemainingValue) }}
                        </td>
                        <td>
                            <action-buttons :delete-tooltip="'Deletar Fatura'"
                                            :tooltip-edit="'Editar Fatura'"
                                            :edit-to="'/gerenciar-cartoes/despesa/' + expense.id + '/atualizar'"
                                            @delete-clicked="deleteExpense(expense.id, expense.name)"/>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <!-- todo aparecer somente se tiver fatura -->
                        <td v-for="(month, index) in months" :key="index">
                            <button class="btn btn-full btn-success rounded-5"
                                    @click="payInvoice(month)"
                                    v-tooltip="'Pagar parcela'">
                                <font-awesome-icon :icon="iconEnum.creditCard()" />
                            </button>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <hr class="mt-4">
            <!-- todo criar ação de pagar fatura -->
        </div>
    </div>
</template>

<script>
    import Message from "../../../components/MessageComponent.vue";
    import LoadingComponent from "../../../components/LoadingComponent.vue";
    import CalendarTools from "../../../../js/tools/calendarTools";
    import iconEnum from "../../../../js/enums/iconEnum";
    import apiRouter from "../../../../js/router/apiRouter";
    import calendarTools from "../../../../js/tools/calendarTools";
    import StringTools from "../../../../js/tools/stringTools";
    import messageEnum from "../../../../js/enums/messageEnum";
    import ActionButtons from "../../../components/ActionButtons.vue";

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
            ActionButtons,
            LoadingComponent,
            Message
        },
        data() {
            return {
                invoices: {},
                title: null,
                loadingDone: false,
                message: null,
                messageType: null,
                thisMonth: null,
                months: [],
                messageTimeOut: CalendarTools.fiveHundredMs()
            }
        },
        methods: {
            async deleteExpense(id, name) {
                if (confirm('Deseja realmente deletar a despesa ' + name + '?')) {
                    await apiRouter.cards.invoices.delete(id)
                    this.message = 'Despesa deletada com sucesso!'
                    this.messageType = messageEnum.messageTypeSuccess()
                    this.invoices = await apiRouter.cards.invoices.index(11)
                    this.resetMessage()
                }
            },
            resetMessage() {
                $(window).scrollTop(0, 0)
                setTimeout(() =>
                        [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            },
            async payInvoice(month) {
                // todo desenvolver
                console.log('desenvolver', month)
                // payInvoice
                // reloadInvoices
            }
        },
        async mounted() {
            // todo 'Fatura ' + cardName
            this.title = 'Fatura';
            this.invoices = await apiRouter.cards.invoices.index(this.$route.params.id)
            this.thisMonth = CalendarTools.getThisMonth()
            this.months = [
                this.thisMonth,
                this.thisMonth + 1,
                this.thisMonth + 2,
                this.thisMonth + 3,
                this.thisMonth + 4,
                this.thisMonth + 5
            ]
        }
    }
</script>