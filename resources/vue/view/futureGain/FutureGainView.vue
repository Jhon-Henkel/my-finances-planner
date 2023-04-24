<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <message :message="message" :type="messageType" v-show="message"/>
            <div class="nav mt-2 justify-content-end">
                <h3 id="title">Ganhos Futuros</h3>
                <router-link class="btn btn-success rounded-5" to="/ganhos-futuros/cadastrar">
                    <font-awesome-icon :icon="iconEnum.sackDollar()" class="me-2"/>
                    Novo Ganho Futuro
                </router-link>
            </div>
            <hr class="mb-4">
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Descrição</th>
                        <th>Carteira</th>
                        <th scope="col" v-for="(month, index) in months" :key="index">
                            {{ calendarTools.getMonthNameByNumber(month) }}
                        </th>
                        <th>Restam</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="gain in futureGains" :key="gain.id" class="text-center">
                        <td>{{ gain.name }}</td>
                        <td>{{ gain.countName }}</td>
                        <td>{{ gain.firstInstallment ? StringTools.formatFloatValueToBrString(gain.firstInstallment) : '-' }}</td>
                        <td>{{ gain.secondInstallment ? StringTools.formatFloatValueToBrString(gain.secondInstallment) : '-' }}</td>
                        <td>{{ gain.thirdInstallment ? StringTools.formatFloatValueToBrString(gain.thirdInstallment) : '-' }}</td>
                        <td>{{ gain.forthInstallment ? StringTools.formatFloatValueToBrString(gain.forthInstallment) : '-' }}</td>
                        <td>{{ gain.fifthInstallment ? StringTools.formatFloatValueToBrString(gain.fifthInstallment) : '-' }}</td>
                        <td>{{ gain.sixthInstallment ? StringTools.formatFloatValueToBrString(gain.sixthInstallment) : '-' }}</td>
                        <td>{{ gain.remainingInstallments === 0 ? 'Fixo' : gain.remainingInstallments }}</td>
                        <td class="text-center">
                            <action-buttons
                                :delete-tooltip="'Deletar Ganho'"
                                :tooltip-edit="'Editar Ganho'"
                                :edit-to="'/ganhos-futuros/' + gain.id + '/atualizar'"
                                :check-button="showCheckButton(gain)"
                                :check-tooltip="'Marcar próxima como recebido'"
                                @delete-clicked="deleteGain(gain.id, gain.name)"
                                @check-clicked="receiveGain(gain.id, gain.name)"/>
                        </td>
                    </tr>
                    <tr class="text-center border-table">
                        <td>Total</td>
                        <td></td>
                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.firstMonth) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.secondMonth) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.thirdMonth) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.forthMonth) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.fifthMonth) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.sixthMonth) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <hr class="mt-4">
            <div class="text-end">
                <h3>Total previsto: {{ StringTools.formatFloatValueToBrString(totalPerMonth.total) }}</h3>
            </div>
        </div>
    </div>
</template>

<script>
    import Message from "../../components/MessageComponent.vue";
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import CalendarTools from "../../../js/tools/calendarTools";
    import ActionButtons from "../../components/ActionButtons.vue";
    import calendarTools from "../../../js/tools/calendarTools";
    import ApiRouter from "../../../js/router/apiRouter";
    import MessageEnum from "../../../js/enums/messageEnum";
    import StringTools from "../../../js/tools/stringTools";
    import NumberTools from "../../../js/tools/numberTools";

    export default {
        name: "FutureGainView",
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
                loadingDone: false,
                message: null,
                messageType: null,
                months: [],
                totalPerMonth: {
                    firstMonth: 0,
                    secondMonth: 0,
                    thirdMonth: 0,
                    forthMonth: 0,
                    fifthMonth: 0,
                    sixthMonth: 0,
                    total: 0
                },
                futureGains: {},
                messageTimeOut: CalendarTools.fiveSecondsTimeInMs()
            }
        },
        methods: {
            resetMessage() {
                setTimeout(() =>
                    [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            },
            async updateFutureGainsList() {
                await ApiRouter.futureGain.getNextSixMonthsGains().then(response => {
                    this.futureGains = response
                    this.calculateTotalPerMonth()
                }).catch(error => {
                    this.message = 'Não foi possível carregar os ganhos futuros!'
                    this.messageType = MessageEnum.messageTypeError()
                    this.resetMessage()
                })
            },
            calculateTotalPerMonth() {
                let totalPerMonthCount = NumberTools.calculateTotalPerMonthInvoiceItem(this.futureGains)
                this.totalPerMonth.firstMonth = totalPerMonthCount.firstMonth
                this.totalPerMonth.secondMonth = totalPerMonthCount.secondMonth
                this.totalPerMonth.thirdMonth = totalPerMonthCount.thirdMonth
                this.totalPerMonth.forthMonth = totalPerMonthCount.forthMonth
                this.totalPerMonth.fifthMonth = totalPerMonthCount.fifthMonth
                this.totalPerMonth.sixthMonth = totalPerMonthCount.sixthMonth
                this.totalPerMonth.total = totalPerMonthCount.total
            },
            async deleteGain(id, gainName) {
                if(confirm("Tem certeza que realmente quer deletar o ganho " + gainName + '?')) {
                    await ApiRouter.futureGain.delete(id).then(response => {
                        this.message = 'Ganho deletado com sucesso!'
                        this.messageType = MessageEnum.messageTypeSuccess()
                        this.resetMessage()
                        this.updateFutureGainsList()
                    }).catch(error => {
                        this.message = 'Não foi possível deletar o ganho!'
                        this.messageType = MessageEnum.messageTypeError()
                        this.resetMessage()
                    })
                }
            },
            async receiveGain(id, gainName) {
                if(confirm("Voce confirma o recebimento de " + gainName + '?')) {
                    await ApiRouter.futureGain.receive(id).then(response => {
                        this.message = 'Ganho recebido com sucesso!'
                        this.messageType = MessageEnum.messageTypeSuccess()
                        this.resetMessage()
                        this.updateFutureGainsList()
                    }).catch(error => {
                        this.message = 'Não foi possível receber o ganho!'
                        this.messageType = MessageEnum.messageTypeError()
                        this.resetMessage()
                    })
                }
            },
            showCheckButton(gain) {
                if (
                    ! gain.firstInstallment
                    && ! gain.secondInstallment
                    && ! gain.thirdInstallment
                    && ! gain.forthInstallment
                    && ! gain.fifthInstallment
                    && ! gain.sixthInstallment
                ) {
                    return false
                }
                return true
            }
        },
        async mounted() {
            this.thisMonth = CalendarTools.getThisMonth()
            this.months = [
                this.thisMonth,
                this.thisMonth + 1,
                this.thisMonth + 2,
                this.thisMonth + 3,
                this.thisMonth + 4,
                this.thisMonth + 5
            ]
            await this.updateFutureGainsList()
        }
    }
</script>

<style scoped>
    .border-table {
        border-top: 2px solid #096452;
    }
</style>