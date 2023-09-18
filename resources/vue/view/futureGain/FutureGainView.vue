<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Ganhos Futuros'"/>
                <router-link class="btn btn-success rounded-2 top-button" to="/ganhos-futuros/cadastrar">
                    <font-awesome-icon :icon="iconEnum.sackDollar()" class="me-2"/>
                    Novo Ganho Futuro
                </router-link>
            </div>
            <divider/>
            <div class="card glass success balance-card">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th><font-awesome-icon :icon="iconEnum.calendarCheck()"/></th>
                                        <th>Descrição</th>
                                        <th>Carteira</th>
                                        <th scope="col" v-for="(month, index) in months" :key="index">
                                            {{ CalendarTools.getMonthNameByNumber(month) }}
                                        </th>
                                        <th>Restam</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-hover">
                                    <tr v-show="futureGains.length === 0" class="text-center">
                                        <td colspan="11">Nenhum ganho cadastrado ainda!</td>
                                    </tr>
                                    <tr v-for="gain in futureGains" :key="gain.id" class="text-center">
                                        <td>{{ gain.nextInstallmentDay }}</td>
                                        <td class="text-start">{{ gain.name }}</td>
                                        <td class="text-start">{{ gain.countName }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.firstInstallment) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.secondInstallment) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.thirdInstallment) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.forthInstallment) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.fifthInstallment) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.sixthInstallment) }}</td>
                                        <td v-if="gain.remainingInstallments === 0" v-tooltip="'Ganho Fixo'">Fixo</td>
                                        <td v-else v-tooltip="StringTools.formatFloatValueToBrString(gain.totalRemainingValue)">
                                            {{ gain.remainingInstallments }}
                                        </td>
                                        <td class="text-center">
                                            <action-buttons
                                                :delete-tooltip="'Deletar Ganho'"
                                                :tooltip-edit="'Editar Ganho'"
                                                :edit-to="'/ganhos-futuros/' + gain.id + '/atualizar'"
                                                :check-button="showCheckButton(gain)"
                                                :check-tooltip="'Marcar próxima como recebido'"
                                                @delete-clicked="deleteGain(gain.id, gain.name)"
                                                @check-clicked="showReceiveGainForm(
                                                    gain.id,
                                                    gain.countId,
                                                    getNextGainValue(gain),
                                                    gain.name
                                                )"
                                            />
                                        </td>
                                    </tr>
                                    <tr class="text-center border-table">
                                        <td colspan="3">Total</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.firstMonth) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.secondMonth) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.thirdMonth) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.forthMonth) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.fifthMonth) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.sixthMonth) }}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <pay-receive :show-pay-receive="showReceiveGain"
                         :value="receiveGainValue"
                         :check-tooltip="'Receber Ganho'"
                         :wallet-id="receiveGainWalletId"
                         :partial-label="'Receber Parcial'"
                         @hide-pay-receive="showReceiveGain = false"
                         @pay="receiveGain($event)"/>
            <div class="row ms-1 mt-4">
                <div class="card glass balance-card card-resume balance-card-resume">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            <font-awesome-icon :icon="iconEnum.wallet()" class="me-2"/>
                            Resumo
                        </h4>
                        <hr>
                        <div class="card-text card-text-resume">
                            <div class="row">
                                <div class="col-12">
                                    <h6>Total previsto no período</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    {{ StringTools.formatFloatValueToBrString(totalPerMonth.total) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <divider/>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue'
import iconEnum from '../../../js/enums/iconEnum'
import CalendarTools from '../../../js/tools/calendarTools'
import ActionButtons from '../../components/ActionButtons.vue'
import ApiRouter from '../../../js/router/apiRouter'
import MessageEnum from '../../../js/enums/messageEnum'
import StringTools from '../../../js/tools/stringTools'
import NumberTools from '../../../js/tools/numberTools'
import Divider from '../../components/DividerComponent.vue'
import MfpTitle from '../../components/TitleComponent.vue'
import MfpMessage from '../../components/MessageAlert.vue'
import PayReceive from '../../components/PayReceiveComponent.vue'

export default {
    name: 'FutureGainView',
    computed: {
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
        PayReceive,
        MfpMessage,
        MfpTitle,
        Divider,
        ActionButtons,
        LoadingComponent
    },
    data() {
        return {
            loadingDone: false,
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
            receiveGainValue: 0,
            receiveGainWalletId: 0,
            receiveGainId: 0,
            receiveGainName: '',
            showReceiveGain: false,
            futureGains: {}
        }
    },
    methods: {
        async updateFutureGainsList() {
            await ApiRouter.futureGain.getNextSixMonthsGains().then(response => {
                this.loadingDone = false
                this.futureGains = response
                this.calculateTotalPerMonth()
                this.loadingDone = true
            }).catch(() => {
                this.messageError('Não foi possível carregar os ganhos futuros!')
            })
        },
        calculateTotalPerMonth() {
            const totalPerMonthCount = NumberTools.calculateTotalPerMonthInvoiceItem(this.futureGains)
            this.totalPerMonth.firstMonth = totalPerMonthCount.firstMonth
            this.totalPerMonth.secondMonth = totalPerMonthCount.secondMonth
            this.totalPerMonth.thirdMonth = totalPerMonthCount.thirdMonth
            this.totalPerMonth.forthMonth = totalPerMonthCount.forthMonth
            this.totalPerMonth.fifthMonth = totalPerMonthCount.fifthMonth
            this.totalPerMonth.sixthMonth = totalPerMonthCount.sixthMonth
            this.totalPerMonth.total = totalPerMonthCount.total
        },
        async deleteGain(id, gainName) {
            if (confirm('Tem certeza que realmente quer deletar o ganho ' + gainName + '?')) {
                await ApiRouter.futureGain.delete(id).then(response => {
                    this.messageSuccess('Ganho deletado com sucesso!')
                    this.updateFutureGainsList()
                }).catch(() => {
                    this.messageError('Não foi possível deletar o ganho!')
                })
            }
        },
        async receiveGain(event) {
            const partial = event.partial ? ' de forma parcial' : ''
            let confirmMessage = 'Você confirma o recebimento do ganho '
            confirmMessage = confirmMessage + '"' + this.receiveGainName + '"'
            confirmMessage = confirmMessage + partial
            confirmMessage = confirmMessage + ' no valor de ' + StringTools.formatFloatValueToBrString(event.value)
            if (confirm(confirmMessage + '?')) {
                const object = {
                    walletId: event.walletId,
                    value: event.value,
                    partial: event.partial
                }
                await ApiRouter.futureGain.receive(this.receiveGainId, object).then(response => {
                    this.messageSuccess('Ganho recebido com sucesso!')
                    this.updateFutureGainsList()
                    this.showReceiveGain = false
                }).catch(() => {
                    this.messageError('Não foi possível receber o ganho!')
                })
            }
        },
        showReceiveGainForm(id, countId, value, gainName) {
            this.receiveGainValue = value
            this.receiveGainWalletId = countId
            this.receiveGainId = id
            this.receiveGainName = gainName
            this.showReceiveGain = true
        },
        getNextGainValue(gain) {
            if (gain.firstInstallment) {
                return gain.firstInstallment
            } else if (gain.secondInstallment) {
                return gain.secondInstallment
            } else if (gain.thirdInstallment) {
                return gain.thirdInstallment
            } else if (gain.forthInstallment) {
                return gain.forthInstallment
            } else if (gain.fifthInstallment) {
                return gain.fifthInstallment
            } else if (gain.sixthInstallment) {
                return gain.sixthInstallment
            }
        },
        showCheckButton(gain) {
            if (
                !gain.firstInstallment &&
                    !gain.secondInstallment &&
                    !gain.thirdInstallment &&
                    !gain.forthInstallment &&
                    !gain.fifthInstallment &&
                    !gain.sixthInstallment
            ) {
                return false
            }
            return true
        },
        messageError(message) {
            this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
        },
        messageSuccess(message) {
            this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
        },
        showMessage(type, message, title) {
            this.$refs.message.showAlert(type, message, title)
        }
    },
    async mounted() {
        this.thisMonth = CalendarTools.getThisMonth()
        this.months = CalendarTools.getNextSixMonths(this.thisMonth)
        await this.updateFutureGainsList()
    }
}
</script>

<style lang="scss" scoped>
    @import "../../../sass/variables";

    .border-table {
        border-top: 2px solid $table-line-divider-color;
    }
    .card-resume {
        width: 24rem;
    }
    .balance-card-resume {
        width: 80.5rem;
    }
    .card-text-resume {
        font-size: 1.5rem;
    }
    @media (max-width: 1000px) {
        .nav {
            flex-direction: column;
        }
        .top-button {
            margin-top: 10px;
            border-radius: 8px !important;
        }
        .balance-card-resume {
            width: 97%;
        }
    }
</style>